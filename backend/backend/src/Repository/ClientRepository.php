<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    // Créer un client
    public function create(Client $client): Client
    {
        $this->_em->persist($client);
        $this->_em->flush();

        return $client;
    }

    public function findClientById(int $id): ?Client
    {
        return $this->find($id);
    }

    // Mettre à jour un client
    public function update(Client $client): Client
    {
        $this->_em->flush();
        return $client;
    }

    // Supprimer un client
    public function delete(Client $client): void
    {
        $this->_em->remove($client);
        $this->_em->flush();
    }

    // Trouver tous les clients
    public function findAllClients(): array
    {
        return $this->findAll();
    }
}
