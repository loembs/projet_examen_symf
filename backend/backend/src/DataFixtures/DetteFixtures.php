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

class DetteFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Récupérer tous les clients existants
        $clients = $manager->getRepository(Client::class)->findAll();

        foreach ($clients as $client) {
            for ($i = 1; $i <= 2; $i++) {
                // Créer une demande pour ce client

                // Créer une dette associée à cette demande
                $dette = new Dette();
                $dette->setMontant(2000 * $i);
                $dette->setMontantVerser(1000 * $i);


                // Associer la demande à la dette (de manière bidirectionnelle)
    

                // Ajouter des détails à la demande
                for ($j = 1; $j <= 2; $j++) {
                    $detail = new Detail();
                    $detail->setPrixVente(500); // Exemple de prix de vente
                    $detail->setQteVendu(95);   // Exemple de quantité vendue
                    $detail->setDette($dette);  // Associer ce détail à la dette actuelle

                    // Ajouter des articles à chaque détail
                    $article = new Article(); // Si Article est une entité
                    $article->setLibelle('Article ' . $j);
                    $article->setPrix(100 * $j);
                    $article->setQstock(100); // Exemple de stock
                    $detail->setArticle($article);

                    // Persister l'article
                    $manager->persist($article);
                    $manager->persist($detail);
                }

                // Persister la demande et la dette Ne pas oublier de persister la demande
                $manager->persist($dette);   // Persister la dette
            }
        }

        // Appliquer les modifications à la base de données
        $manager->flush();
    }
}


