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



        for ($i = 1; $i <= 5; $i++) {
            $reference = new Reference();
            $reference->setTitle("Reference " . $i);
            $reference->setCompany("Company " . $i);
            $reference->setDescription("Description " . $i);
            $reference->setStartedAt(new \DateTimeImmutable("10 years ago"));
            $reference->setEndedAt(new \DateTimeImmutable("8 years ago"));
            $media = new Media();
            $media->setPath("uploads/image.png");
            $reference->addMedia($media);
            $manager->persist($reference);

            $skill = new Skill();
            $skill->setLevel(rand(1, 10));
            $skill->setName("Skill " . $i);
            $manager->persist($skill);

            $formation = new Formation();
            $formation->setGradeLevel(rand(0, 5));
            $formation->setDescription("Description " . $i);
            $formation->setSchool("School " . $i);
            $formation->setName("Formation " . $i);
            $formation->setStartedAt(new \DateTimeImmutable("10 years ago"));
            $formation->setEndedAt(new \DateTimeImmutable("8 years ago"));
            $manager->persist($formation);
        }

        $manager->flush();
    }
}