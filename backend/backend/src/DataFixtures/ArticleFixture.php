<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ArticleFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création d'articles aléatoires
        for ($i = 1; $i <= 4; $i++) {
            $article = new Article();
            $article->setLibelle('Article ' . $i);
            $article->setPrix(mt_rand(100, 1000));  // Prix unitaire aléatoire entre 100 et 1000
            $article->setQstock(mt_rand(10, 100));  // Quantité en stock entre 10 et 100

            $manager->persist($article);
        }

        $manager->flush();
    }
}
