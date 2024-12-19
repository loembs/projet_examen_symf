<?php

namespace App\Repository;

use App\Entity\Dette;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DetteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dette::class);
    }

    // Créer une dette
    public function create(Dette $dette): Dette
    {
        $this->_em->persist($dette);
        $this->_em->flush();

        return $dette;
    }

    // Lire une dette par son ID
    public function findDetteById(int $id): ?Dette
    {
        return $this->find($id);
    }

    // Mettre à jour une dette
    public function update(Dette $dette): Dette
    {
        $this->_em->flush();
        return $dette;
    }

    // Supprimer une dette
    public function delete(Dette $dette): void
    {
        $this->_em->remove($dette);
        $this->_em->flush();
    }

    // Trouver toutes les dettes
    public function findAllDettes(): array
    {
        return $this->findAll();
    }
}

