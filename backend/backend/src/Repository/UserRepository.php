<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    // Créer un utilisateur
    public function create(User $user): User
    {
        $this->_em->persist($user);
        $this->_em->flush();

        return $user;
    }

    // Lire un utilisateur par son ID
    public function findUserById(int $id): ?User
    {
        return $this->find($id);
    }

    // Mettre à jour un utilisateur
    public function update(User $user): User
    {
        $this->_em->flush();
        return $user;
    }

    // Supprimer un utilisateur
    public function delete(User $user): void
    {
        $this->_em->remove($user);
        $this->_em->flush();
    }

    // Trouver tous les utilisateurs
    public function findAllUsers(): array
    {
        return $this->findAll();
    }

    // Mettre à jour le mot de passe de l'utilisateur
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }
}
