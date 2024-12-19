<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\TypeInfo\TypeResolver;

use PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use PHPStan\PhpDocParser\Lexer\Lexer;
use PHPStan\PhpDocParser\Parser\ConstExprParser;
use PHPStan\PhpDocParser\Parser\PhpDocParser;
use PHPStan\PhpDocParser\Parser\TokenIterator;
use PHPStan\PhpDocParser\Parser\TypeParser;
use PHPStan\PhpDocParser\ParserConfig;
use Symfony\Component\TypeInfo\Exception\UnsupportedException;
use Symfony\Component\TypeInfo\Type;
use Symfony\Component\TypeInfo\TypeContext\TypeContext;
use Symfony\Component\TypeInfo\TypeContext\TypeContextFactory;

/**
 * Resolves type on reflection prioriziting PHP documentation.
 *
 * @author Mathias Arlaud <mathias.arlaud@gmail.com>
 */
final readonly class PhpDocAwareReflectionTypeResolver implements TypeResolverInterface
{
    private PhpDocParser $phpDocParser;
    private Lexer $lexer;

    public function __construct(
        private TypeResolverInterface $reflectionTypeResolver,
        private TypeResolverInterface $stringTypeResolver,
        private TypeContextFactory $typeContextFactory,
        ?PhpDocParser $phpDocParser = null,
        ?Lexer $lexer = null,
    ) {
        if (class_exists(ParserConfig::class)) {
            $this->lexer = $lexer ?? new Lexer(new ParserConfig([]));
            $this->phpDocParser = $phpDocParser ?? new PhpDocParser(
                $config = new ParserConfig([]),
                new TypeParser($config, $constExprParser = new ConstExprParser($config)),
                $constExprParser,
            );
        } else {
            $this->lexer = $lexer ?? new Lexer();
            $this->phpDocParser = $phpDocParser ?? new PhpDocParser(
                new TypeParser($constExprParser = new ConstExprParser()),
                $constExprParser,
            );
        }
    }

    public function resolve(mixed $subject, ?TypeContext $typeContext = null): Type
    {
        if (!$subject instanceof \ReflectionProperty && !$subject instanceof \ReflectionParameter && !$subject instanceof \ReflectionFunctionAbstract) {
            throw new UnsupportedException(\sprintf('Expected subject to be a "ReflectionProperty", a "ReflectionParameter" or a "ReflectionFunctionAbstract", "%s" given.', get_debug_type($subject)), $subject);
        }

        $docComment = match (true) {
            $subject instanceof \ReflectionProperty => $subject->getDocComment(),
            $subject instanceof \ReflectionParameter => $subject->getDeclaringFunction()->getDocComment(),
            $subject instanceof \ReflectionFunctionAbstract => $subject->getDocComment(),
        };

        if (!$docComment) {
            return $this->reflectionTypeResolver->resolve($subject);
        }

        $typeContext ??= $this->typeContextFactory->createFromReflection($subject);

        $tagName = match (true) {
            $subject instanceof \ReflectionProperty => '@var',
            $subject instanceof \ReflectionParameter => '@param',
            $subject instanceof \ReflectionFunctionAbstract => '@return',
        };

        $tokens = new TokenIterator($this->lexer->tokenize($docComment));
        $docNode = $this->phpDocParser->parse($tokens);

        foreach ($docNode->getTagsByName($tagName) as $tag) {
            $tagValue = $tag->value;

            if (
                $tagValue instanceof VarTagValueNode
                || $tagValue instanceof ParamTagValueNode && $tagName && '$'.$subject->getName() === $tagValue->parameterName
                || $tagValue instanceof ReturnTagValueNode
            ) {
                return $this->stringTypeResolver->resolve((string) $tagValue, $typeContext);
            }
        }

        return $this->reflectionTypeResolver->resolve($subject);
    }
}
