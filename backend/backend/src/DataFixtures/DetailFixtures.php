<?php

namespace App\DataFixtures;

use App\Entity\Detail;
use App\Entity\Dette;
use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DetailFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Récupérer toutes les dettes existantes
        $dettes = $manager->getRepository(Dette::class)->findAll();

        foreach ($dettes as $dette) {
            // Créer plusieurs détails pour chaque dette
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
                $article->setQstock(100);// Exemple de prix
                $manager->persist($article);

                // Associer l'article à la dette via ses détails si nécessaire
                // (ajuster en fonction de tes relations dans l'entité `DetailDette`)
                $detail->setArticle($article);
                // Persister le détail
                $manager->persist($detail);
            }
        }

        $manager->flush();
    }
}
