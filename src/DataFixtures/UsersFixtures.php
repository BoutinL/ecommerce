<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;

class UsersFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordEncoder, private SluggerInterface $slugger)
    {
    }
    // Nous définissons un constructeur en lmode PHP8.
    // Les objets de l'entité UsersFixtures possèderont donc 2 propriétés, le slugger, indispensable pour générer la fixture,
    // et l'interface de hash du mot de passe, indispensable dans le cas présent pour encrypter les mots de passe que nous
    // octroierons aux comptes
    public function load(ObjectManager $manager): void
    {
        $admin = new Users();
        $admin->setEmail('admin@ecommerce.com');
        $admin->setLastname('Orluk');
        $admin->setFirstname('Alain');
        $admin->setAddress('2c rue des fleurs');
        $admin->setZipcode('67560');
        $admin->setCity('Rosheim');
        $admin->setPassword($this->passwordEncoder->hashPassword($admin, 'azertyuiop'));
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        $faker = Factory::create('fr');

        for ($usr = 1; $usr <= 5; $usr++) {
            $user = new Users();
            $user->setEmail($faker->email);
            $user->setLastname($faker->lastName);
            $user->setFirstname($faker->firstName);
            $user->setAddress($faker->streetAddress);
            $user->setZipcode(str_replace(' ','', $faker->postcode));
            $user->setCity($faker->city);
            $user->setPassword($this->passwordEncoder->hashPassword($user, '123456789'));
            // Il faut définir le mot de passe sinon nous ne pourrions pas le connaître
            // puisqu'il sera diretement encrypté dans la table Users.
            dump($user);
            $manager->persist($user);
        }
        $manager->flush();
    }
}
