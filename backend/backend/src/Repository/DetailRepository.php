<?php
namespace App\Repository;

use App\Entity\Detail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DetailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Detail::class);
    }

  
    public function findByDemandeId(int $demandeId): array
    {
        return $this->createQueryBuilder('d')
            ->where('d.demande = :demandeId')
            ->setParameter('demandeId', $demandeId)
            ->getQuery()
            ->getResult();
    }

    public function save(Detail $detail): void
    {
        $this->_em->persist($detail);
        $this->_em->flush();
    }

    public function remove(Detail $detail): void
    {
        $this->_em->remove($detail);
        $this->_em->flush();
    }
}
