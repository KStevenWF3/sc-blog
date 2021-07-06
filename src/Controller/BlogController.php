<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    //! Ci-dessous le chemin d'accès dans l'url pour activer cette méthode pour le template à charger.
    /**
     * @Route("/blog", name="blog")
     */
    public function blog(): Response
    {
        //* traitement selection BDD des articles
        //* $reportArticles est un objet issu de la classe ArticleRepository
        $reportArticles = $this->getDoctrine()->getRepository(Article::class);
        // symfony à sa propre fonction var_dump
        dump($reportArticles);

        $articles = $reportArticles->findAll();
        dump($articles);

        return $this->render('blog/blog.html.twig', [
            'controller_name' => 'BlogController',
            //! {{ controller_name }} sur vue donnera "BlogController
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        return $this->render('blog/home.html.twig', [
            'title' => 'Blog dédié à la musique, viendez voir, ça déchire !!!',
            'age' => 25
        ]);
    }

    /**
     * Méthode permettant d'afficher le détail d'un article
     * 
     * @Route("/blog/12", name="blog_show")
     */
    public function show(): Response
    {
        return $this->render('blog/show.html.twig');
    }
}
