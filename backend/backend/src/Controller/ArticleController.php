<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ArticleRepository;

class ArticleController extends AbstractController
{
    #[Route('/api/articles', name: 'api_articles', methods: ['GET', 'POST'])]
    public function sendArticles(ArticleRepository $articleRepository): JsonResponse
    {
        // Récupérer tous les articles de la base de données
        $articles = $articleRepository->findAll();

        // Transformer les articles en un tableau de données simples
        $data = [];
        foreach ($articles as $article) {
            $data[] = [
                'id' => $article->getId(),
                'libelle' => $article->getLibelle(),
                'prix' => $article->getPrix(),
                'qteStock' => $article->getQstock(),
            ];
        }

        // Retourner les données sous forme de JSON
        return new JsonResponse($data);
    }
}