<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\DetailRepository;

class DetailController extends AbstractController
{
    #[Route('/api/details', name: 'api_details', methods: ['GET', 'POST'])]
    public function sendDetails(DetailRepository $detailRepository): JsonResponse
    {
        // Récupérer tous les détails de la base de données
        $details = $detailRepository->findAll();

        // Transformer les détails en un tableau de données simples
        $data = [];
        foreach ($details as $detail) {
            $data[] = [
                'id' => $detail->getId(),
                'article' => $detail->getArticle()->getLibelle(),
                'quantite' => $detail->getQuantite(),
                'prix' => $detail->getPrix(),
            ];
        }

        // Retourner les données sous forme de JSON
        return new JsonResponse($data);
    }
}
