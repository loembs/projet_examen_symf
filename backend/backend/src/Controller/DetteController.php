<?php
namespace App\Controller;

use App\Repository\DetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class DetteController extends AbstractController
{
    #[Route('/api/dettes', name: 'api_dettes', methods: ['GET'])]
    public function getDettes(DetteRepository $detteRepository): JsonResponse
    {
        // Récupérer toutes les dettes de la base de données
        $dettes = $detteRepository->findAll();

        // Transformer les dettes en un tableau de données simples
        $data = [];
        foreach ($dettes as $dette) {
            $data[] = [
                'id' => $dette->getId(),
                'montant' => $dette->getMontant(),
                'date' => $dette->getDate(),
                'status' => $dette->getStatus(),
            ];
        }

        // Retourner les données sous forme de JSON
        return new JsonResponse($data);
    }
}
