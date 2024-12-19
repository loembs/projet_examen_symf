<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

class SecurityController extends AbstractController
{
    #[Route(path: '/api/login', name: 'api_login', methods: ['POST'])]
    public function login(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): JsonResponse
    {
        // Récupérer les données envoyées par le client
        $data = json_decode($request->getContent(), true);
        $login = $data['login'] ?? null;
        $password = $data['password'] ?? null;

        if (!$login || !$password) {
            return new JsonResponse(['error' => 'Invalid credentials.'], 400);
        }

        // Rechercher l'utilisateur dans la base de données avec le login
        $user = $entityManager->getRepository(User::class)->findOneBy(['login' => $login]);

        if (!$user || !$passwordHasher->isPasswordValid($user, $password)) {
            throw new BadCredentialsException('Invalid credentials.');
        }

        // Simuler la génération de JWT (à remplacer par une vraie implémentation JWT)
        $mockToken = base64_encode(json_encode([
            'user_id' => $user->getId(),
            'login' => $user->getLogin(),
            'exp' => time() + 3600, // Expiration dans 1 heure
        ]));

        return new JsonResponse([
            'token' => $mockToken,
            'user' => [
                'id' => $user->getId(),
                'login' => $user->getLogin(),
                'roles' => $user->getRoles(),
            ]
        ]);
    }

    #[Route(path: '/api/logout', name: 'api_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}


