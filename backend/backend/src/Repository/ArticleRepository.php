<?php
namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    // Créer un article
    public function create(Article $article): Article
    {
        $this->_em->persist($article);
        $this->_em->flush();

        return $article;
    }

    // Lire un article par son ID
    public function findArticleById(int $id): ?Article
    {
        return $this->find($id);
    }

    // Mettre à jour un article
    public function update(Article $article): Article
    {
        $this->_em->flush();
        return $article;
    }

    // Supprimer un article
    public function delete(Article $article): void
    {
        $this->_em->remove($article);
        $this->_em->flush();
    }

    // Trouver tous les articles
    public function findAllArticles(): array
    {
        return $this->findAll();
    }

    // Trouver des articles par catégorie
    public function findArticlesByCategory(string $category): array
    {
        return $this->createQueryBuilder('a')
                    ->where('a.category = :category')
                    ->setParameter('category', $category)
                    ->getQuery()
                    ->getResult();
    }

    // Trouver des articles en fonction du prix minimum et maximum

    // Trouver des articles avec un nom similaire
    public function findArticlesByName(string $name): array
    {
        return $this->createQueryBuilder('a')
                    ->where('a.name LIKE :name')
                    ->setParameter('name', '%' . $name . '%')
                    ->getQuery()
                    ->getResult();
    }
}
