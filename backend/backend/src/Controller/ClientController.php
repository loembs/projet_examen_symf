<?php
namespace App\Controller;

use App\Repository\ClientRepository;
use App\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request; 

class ClientController extends AbstractController
{
    #[Route('/api/clients', name: 'api_clients', methods: ['GET'])]
    public function getClients(ClientRepository $clientRepository): JsonResponse
    {
        // Récupérer tous les clients de la base de données
        $clients = $clientRepository->findAll();

        // Transformer les clients en un tableau de données simples
        $data = [];
        foreach ($clients as $client) {
            $data[] = [
                'id' => $client->getId(),
                'surname'=> $client->getSurname(),
                'telephone' => $client->getTelephone(),
                'adresse' => $client->getAdresse(),
            ];
        }

        // Retourner les données sous forme de JSON
        return new JsonResponse($data);
    }
     // Route pour enregistrer un client
     #[Route('/api/clients', name: 'api_create_client', methods: ['POST'])]
    public function createClient(Request $request, ClientRepository $clientRepository): JsonResponse
    {
        // Récupérer les données JSON envoyées dans la requête
        $data = json_decode($request->getContent(), true);

        // Valider les données
        if (!isset($data['surname']) || !isset($data['telephone']) || !isset($data['adresse'])) {
            return new JsonResponse(['message' => 'Données manquantes'], 400);
        }

        // Créer un nouveau client
        $client = new Client();
        $client->setSurname($data['surname']);
        $client->setTelephone($data['telephone']);
        $client->setAdresse($data['adresse']);

        // Sauvegarder le client dans la base de données
        $clientRepository->create($client);

        // Retourner une réponse avec le client créé
        return new JsonResponse([
            'message' => 'Client créé avec succès',
            'client' => [
                'id' => $client->getId(),
                'surname' => $client->getSurname(),
                'telephone' => $client->getTelephone(),
                'adresse' => $client->getAdresse(),
            ]
        ], 201);
    }

}

