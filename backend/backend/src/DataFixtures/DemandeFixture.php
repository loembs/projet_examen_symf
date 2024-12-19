<?php

namespace App\DataFixtures;

use App\Entity\Demande;
use App\Entity\Client;
use App\Entity\Detail;
use App\Entity\Dette;
use App\Entity\Article;
use App\Enum\EtatDemande;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class DemandeFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création d'une demande avec des détails et une dette pour chaque client
        $clients = $manager->getRepository(Client::class)->findAll();

        foreach ($clients as $client) {
            for ($i = 1; $i <= 2; $i++) {
                // Création de la demande
                $demande = new Demande();
                $demande->setEtat(EtatDemande::EN_COURS);
                $demande->setClient($client);
                $demande->setMontantDemande(1000 * $i);
                $demande->setDateRelance(new \DateTimeImmutable('2024-01-01'));

                // Création de la dette
                $dette = new Dette();
                $dette->setMontant(2000 * $i);
                $dette->setMontantVerser(1000 * $i); // Associer la demande à la dette

                // Ajouter des détails à la demande
                for ($j = 1; $j <= 2; $j++) {
                    $detail = new Detail();
                    $detail->setPrixVente(500); // Exemple : montant calculé dynamiquement
                    $detail->setQteVendu(95); // Exemple : Date dynamique
                    $detail->setDette($dette); // Associer ce détail à la dette actuelle

                    // Ajouter des articles si nécessaire (si Article est une entité)
                    // Ex : Création fictive d'articles à partir d'une boucle
                    $article = new Article(); // Si Article est une entité.
                    $article->setLibelle('Article ' . $j);
                    $article->setPrix(100 * $j);
                    $article->setQstock(100); // Exemple de prix
                    $detail->setArticle($article);
                    $manager->persist($article);
                    $manager->persist($detail);
                }

                $manager->persist($demande);
            }
        }

        $manager->flush();
    }
}

