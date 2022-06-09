<?php

namespace App\Controller\FrontOffice;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
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





        #[Route(path: '/login', name: 'app_login')]
        /**
         * @param AuthenticationUtils $authenticationUtils
         * @return Response
         */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $admin = new User();
        $admin->setEmail("admin@email.com");

        $hashPassword = $this->hasher->hashPassword(
            $admin,
            'password'

        );
        $admin->setPassword($hashPassword);
        $manager->persist($admin);

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
