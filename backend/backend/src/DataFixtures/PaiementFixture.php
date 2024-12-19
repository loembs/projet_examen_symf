<?php

namespace App\DataFixtures;

use App\Entity\Paiement;
use App\Entity\Dette;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PaiementFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $dettes = $manager->getRepository(Dette::class)->findAll();

        foreach ($dettes as $dette) {
            // Créer un paiement pour chaque dette
            $paiement = new Paiement();
            $paiement->setMontant($dette->getMontantVerser()); // Paiement égal au montant versé de la dette
            $paiement->setDatePaiement(new \DateTimeImmutable('2024-01-15')); // Date de paiement fixe pour la fixture
            $paiement->setDette($dette); // Associer la dette au paiement

            // Persister le paiement
            $manager->persist($paiement);
        }

        $manager->flush();
    }
}
