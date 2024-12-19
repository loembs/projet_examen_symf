<?php
namespace App\Controller;

use App\Repository\DemandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DemandeController extends AbstractController
{
    #[Route('/api/demandes', name: 'api_demandes', methods: ['GET','POST'])]
    public function getDemandes(DemandeRepository $demandeRepository): JsonResponse
    {
        // Récupérer toutes les demandes de la base de données
        $demandes = $demandeRepository->findAll();

        // Transformer les demandes en un tableau de données simples
        $data = [];
        foreach ($demandes as $demande) {
            $data[] = [
                'id' => $demande->getId(),
                'type' => $demande->getType(),
                'client' => [
                    'id' => $demande->getClient()->getId(),
                    'surname' => $demande->getClient()->getSurname(), // Adaptez selon les attributs de Client
                ],
                'etat' => $demande->getEtat()->name, // Utilisation de l'énumération de l'état
                'dateRelance' => $demande->getDateRelance()->format('Y-m-d H:i:s'),
                'montantDemande' => $demande->getMontantDemande(),
                'details' => array_map(function ($detail) {
                    return [
                        'id' => $detail->getId(),
                        'article' => $detail->getArticle()->getLibelle(), // Adaptez selon les attributs de Detail
                        'quantite' => $detail->getQuantite(),
                        'prix' => $detail->getPrix(),
                    ];
                }, $demande->getDetails()->toArray()),
                'dette' => $demande->getDette() ? [
                    'id' => $demande->getDette()->getId(),
                    'montant' => $demande->getDette()->getMontant(),
                    'statut' => $demande->getDette()->getStatut()->name, // Adaptez si nécessaire
                ] : null,
            ];
        }

        // Retourner les données sous forme de JSON
        return new JsonResponse($data);
    }

    #[Route('/api/demande/{id}', name: 'api_demande', methods: ['GET','POST'])]
    public function getDemandeById(int $id, DemandeRepository $demandeRepository): JsonResponse
    {
        // Trouver une demande par ID
        $demande = $demandeRepository->find($id);

        if (!$demande) {
            return new JsonResponse(['message' => 'Demande not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        // Retourner les données de la demande sous forme de JSON
        $data = [
            'id' => $demande->getId(),
            'client' => [
                'id' => $demande->getClient()->getId(),
                'surname' => $demande->getClient()->getSurname(),
                'telephone' => $demande->getClient()->getTelephone(),// Adaptez selon les attributs de Client
            ],
            'etat' => $demande->getEtat()->name,
            'dateRelance' => $demande->getDateRelance()->format('Y-m-d H:i:s'),
            'montantDemande' => $demande->getMontantDemande(),
            'details' => array_map(function ($detail) {
                return [
                    'id' => $detail->getId(),
                    'article' => $detail->getArticle()->getLibelle(), // Adaptez selon les attributs de Detail
                    'quantite' => $detail->getQuantite(),
                    'prix' => $detail->getPrix(),
                ];
            }, $demande->getDetails()->toArray()),
            'dette' => $demande->getDette() ? [
                'id' => $demande->getDette()->getId(),
                'montant' => $demande->getDette()->getMontant(),
                'statut' => $demande->getDette()->getStatut()->name, // Adaptez si nécessaire
            ] : null,
        ];

        return new JsonResponse($data);
    }
}

