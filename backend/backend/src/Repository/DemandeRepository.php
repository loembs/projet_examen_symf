<?php

namespace App\Repository;

use App\Entity\Demande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DemandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Demande::class);
    }

    // Créer une demande
    public function create(Demande $demande): Demande
    {
        $this->_em->persist($demande);
        $this->_em->flush();

        return $demande;
    }

    // Lire une demande par son ID
    public function findDemandeById(int $id): ?Demande
    {
        return $this->find($id);
    }

    // Mettre à jour une demande
    public function update(Demande $demande): Demande
    {
        $this->_em->flush();
        return $demande;
    }

    // Supprimer une demande
    public function delete(Demande $demande): void
    {
        $this->_em->remove($demande);
        $this->_em->flush();
    }

    // Trouver toutes les demandes
    public function findAllDemandes(): array
    {
        return $this->findAll();
    }
}
