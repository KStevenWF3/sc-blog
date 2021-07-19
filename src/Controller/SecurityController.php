<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * * Méthode permettant l'inscription d'un nouvel utilisateur dans la BDD
     * 
     * @Route("/registration", name="security_registration")
     */
    public function registration(): Response
    {
        return $this->render('security/registration.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
<<<<<<< HEAD
        // Permet de stocker un message d'erreur dans le cas d'erreur de connection, si 'linternaute a saisi le mauvais email ou mdp
=======
>>>>>>> b7bc17a805a798ffc8fb029da70d6770608437b4
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
<<<<<<< HEAD
        // on transmet le mesage d'erreur au template afin de pouvoir l'afficher
=======
>>>>>>> b7bc17a805a798ffc8fb029da70d6770608437b4
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
