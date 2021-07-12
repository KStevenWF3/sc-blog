<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}
