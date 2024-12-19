<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Client;
use App\Enum\Role;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Création de 10 utilisateurs fictifs
        for ($i = 1; $i <= 10; $i++) {
            // Création de l'utilisateur
            $user = new User();
            $user->setLogin('login' . $i);
            $user->setNom('Nom' . $i);
            $user->setPrenom('Prenom' . $i);
            $user->setRole(Role::BOUTIQUIER); // Exemple de rôle, vous pouvez personnaliser selon vos besoins

            // Création du mot de passe
            $plaintextPassword = 'password' . $i;
            $hashedPassword = $this->passwordHasher->hashPassword($user, $plaintextPassword);
            $user->setPassword($hashedPassword);

            // Si le client existe, associez-le à l'utilisateur
            $client = new Client();
            $client->setSurname('ClientNom' . $i);
            $client->setTelephone('77100101' . $i);
            $client->setAdresse('Adresse' . $i);
            $user->setClient($client);

            // Persister l'utilisateur et le client
            $manager->persist($client);
            $manager->persist($user);
        }

        // Sauvegarde de tout dans la base de données
        $manager->flush();
    }
}
