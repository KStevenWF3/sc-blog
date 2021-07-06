<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    //! Ci-dessous le chemin d'accès dans l'url pour activer cette méthode pour le template à charger.
    /**
     * @Route("/blog", name="blog")
     */

     //!\\
     //TODO ONE (reprends : $reportArticles = $this->getDoctrine()->getRepository(Article::class);)
     //!\\
    public function blog(ArticleRepository $reportArticles): Response
    {
        //? Pour selectionner des données dans la table SQL en BDD, nous devons importer la classe Repository qui correspond à la table SQL,
        //? c'està dire à l'entité correspondante (Article).
        //? Une classe Repository permet uniquement de formuler et d'executer des quetes SQL de selection (SELECT)
        //? Cette classe contient des méthodes mis à disposition par symfony pour formuler et executer des requêtes SQL en BDD
        //* traitement selection BDD des articles
        //* $reportArticles est un objet issu de la classe ArticleRepository
        //* // getRepository() : méthode permettant d'importer la classe Repository d'une entité

        // $reportArticles = $this->getDoctrine()->getRepository(Article::class); //! remplacer par ArticleRepository $reportArticles en TODO-ONE

        //* symfony à sa propre fonction var_dump
        dump($reportArticles); // dd()

        //* findall() : SELECT * FROM article + FETCHALL
        //* $articles : tableau ARRAY multidimensionnel contenant l'ensemble des articles stockés dans la BDD
        $articles = $reportArticles->findAll();
        dump($articles);

        return $this->render('blog/blog.html.twig', [
            // 'controller_name' => 'BlogController',
            //! {{ controller_name }} sur vue donnera "BlogController
            'articlesBDD' => $articles
            //* on transmet au template les articles que nous avons selectionnés en BDD afin de les traités et de les afficher avec le language TWIG
            //* extract()
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home(): Response //! la reponse se fait via le render ci-dessous
    {
        return $this->render('blog/home.html.twig', [
            'title' => 'Blog dédié à la musique, viendez voir, ça déchire !!!',
            'age' => 25
        ]);
    }

    //!\\ attention si en dessous de /blog/{id} ne fonctionnera pas car le controller attendra un id et prendra new pour un id
    /**
     * Méthode permettant de créer un nouvel article et de modifier un article existant
     * @Route("/blog/new", name="blog_create")
     */
    public function create(): Response
    {
        return $this->render('blog/create.html.twig',[
            
        ]);
    }

    /**
     * Méthode permettant d'afficher le détail d'un article
     * 
     * @Route("/blog/{id}", name="blog_show")
     */
    // public function show(ArticleRepository $reportArticle, $id): Response
    public function show(Article $article): Response
    {
        //* L'id transmit dans l'URL est envoyé directement en argument de la fonction show(),
        //* ce qui nous permet d'avoir accès à l'id de l'article à selectionner en BDD au sein de la méthode show()
        // dump($id); // récupérer l'id sur la page destination //! grace à la function commenté mais ne fonctionne plus sans elle

        //* importation de la classe ArticleRepository
        // $reportArticle = $this->getDoctrine()->getRepository(Article::class); //! reporté directement sur la function commenté
        // dump($reportArticle);

        //* find() : méthode mise à dispostion par Symfony issue de la classe ArticleRepository permettant de selectionner un élément de la BDD par son ID 
        //* $article : tableau ARRAY contenant toutes les données de l'article selectionné en BDD en fonction de l'ID transmit dans l'URL

        // SELECT * FROM article WHERE id = 6 + FETCH
        // $article = $reportArticle->find($id); //! reporté directement dans la function non commenté
        // dump($article);

        return $this->render('blog/show.html.twig', [
            'articleBDD' => $article
            //* on transmet au template les données de l'article selectionné en BDD afin de lestraiter avec le langage Twig dans le template 
        ]);
    }

}
