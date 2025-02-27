<?php

namespace App\Form;

use App\Entity\Client;
use App\Form\UserType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use App\EventSubscriber\FormClientSubscriber;
use Symfonycasts\DynamicForms\DependentField;
use Symfony\Component\Form\FormBuilderInterface;
use Symfonycasts\DynamicForms\DynamicFormBuilder;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder = new DynamicFormBuilder($builder);

        $builder
            ->add('telephone', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => '773461882',
                    // 'pattern' => '^([77|78|76])[0-9]{7}$',
                    // 'class' => 'text-danger',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner un numéro de téléphone valide.',
                    ]),
                    new NotNull([
                        'message' => 'Le téléphone ne peut pas être vide',
                    ]),
                    new Regex(
                        '/^(77|78|76)([0-9]{7})$/',
                        'Le numéro de téléphone doit être au format 77XXXXXX ou 78XXXXXX ou 76XXXXXX'
                    )
                ]
            ])
            ->add('surname', TextType::class, [
                'required' => false,
            ])

            ->add('adresse', TextareaType::class, [
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner une adresse valide.',
                    ]),
                ]
            ])

            ->add('addUser', CheckboxType::class, [
                'label' => 'Ajouter un compte ?',
                'required' => false,
                'data' => false,
                'mapped' => false,

                'attr' => [
                    'class' => 'form-check-input',
                ],
            ])

            ->addDependent('user', 'addUser', function (DependentField $field, ?string $choice) {
                if (empty($choice)) {
                    return;
                }
                // if ($choice == "1") {
              
                $field
                    ->add(UserType::class, [
                        'label' => false,
                        'attr' => [],
                    ]);
                // }
            })

            // ->add('save', SubmitType::class, [
            //     'attr'=>[
            //         'class' => 'btn btn-primary my-2 my-sm-0'
            //     ]
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
            // APPLICATION CONDITIONNELLE DU GROUPE
            'validation_groups' => function (FormInterface $form) {
                if ($form->has("addUser") && $form->get("addUser")->getData()) {
                    return ['Default', "WITH_COMPTE"];
                }
                return ['Default'];
            }

        ]);
    }
}
