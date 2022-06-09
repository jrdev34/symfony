<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use App\Entity\Formation;
use App\Entity\Media;
use App\Entity\Reference;
use App\Entity\Skill;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordHasherInterface
     */
    private UserPasswordHasherInterface $hasher;


    /**
     * @param UserPasswordHasherInterface $hasher
     */
    public function __construct(UserPasswordHasherInterface $hasher)
    {


        $this -> hasher = $hasher;

    }



    /**
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setEmail("admin@email.com");

            $hashPassword = $this->hasher->hashPassword(
                $admin,
                'password'

            );
             $admin->setPassword($hashPassword);
              $manager->persist($admin);





        $manager->flush();
    }
}