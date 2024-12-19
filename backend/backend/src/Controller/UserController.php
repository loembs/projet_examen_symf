<?php
namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/api/users', name: 'api_users', methods: ['GET'])]
    public function getDettes(UserRepository $userRepository): JsonResponse
    {
        // Récupérer toutes les dettes de la base de données
        $users = $userRepository->findAll();

        // Transformer les dettes en un tableau de données simples
        $data = [];
        foreach ( $users  as  $user) {
            $data[] = [
                'id' => $user->getId(),
                'login' => $user->getLogin(),
                'password' => $user->getPassword(),
                'nom' => $user->getNom(),
                'prenom' =>$user->getPrenom(),
            ];
        }

        // Retourner les données sous forme de JSON
        return new JsonResponse($data);
    }
}
