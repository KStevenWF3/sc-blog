<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class KlawtekController extends AbstractController
{
    /**
     * @Route("/klawtek", name="klawtek")
     */
    public function index(): Response
    {
        return $this->render('klawtek/index.html.twig', [
            'controller_name' => 'KlawtekController',
        ]);
    }
}
