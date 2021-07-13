<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\CommentType;

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
        // dump($reportArticles); // dd()

        //* findall() : SELECT * FROM article + FETCHALL
        //* $articles : tableau ARRAY multidimensionnel contenant l'ensemble des articles stockés dans la BDD
        $articles = $reportArticles->findAll();
        // dump($articles);

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
     * @Route("/blog/new_old", name="blog_create_old")
     */
    public function createOld(Request $request, EntityManagerInterface $manager): Response
    {
        // dump($request);

        //* la prorpiété "$request->request" permet de stocker et d'accéder aux données saisie dans le formulaire,
        //* c'est à dire aux données de la surperloable $_POST
        //* Si les données sont supérieurs à 0; donc si nous avons bien saisie des données dans le formulaire,
        //* alors on entre dans la condition IF
        if($request->request->count() > 0)
        {
            //* Si nous voulons insérer des données dans la table SQL Article, nous devons instancier et remplir
            //* un objet issu de son entité correspondante (classe Article)
            $article = new Article;

            //* On renseigne tout les setteurs de l'objet avec les données saisie dans le formulaire
            // $request->request->get('titre') //** : permet d'atteindre la valeur du titre saisi
            //* dans le champ 'titre" du formulaire
            $article->setTitre($request->request->get('titre'))
                    ->setContenu($request->request->get('contenu'))
                    ->setImage($request->request->get('image'))
                    ->setDate(new \DateTime());
            
            // dump($article);

            //* Pour manipuler les lignes de la BDD (INSERT, UPDATE, DELETE), nous avons besoin d'un manager (EntityManagerInterface)
            //* persist() : méthode issue de l'interface EntityManagerInterface permettant de préparer et garder en mémoire la requete d'insertion
            //* $data = $bdd->prepare("INSERT INTO article VALUES ('$article->geTitre()', '$article->getContenu()')')
            $manager->persist($article);

            //* flush() : méthode issue de l'interface EntityManagerInterface permettant veritablement d'executer la requete d'insertion en BDD
            //* $data->execute()
            $manager->flush();

            dump($article);

            //* Après l'insertion de l'article en BDD, nous redirigeons l'internaute vers l'affichage du détail de l'article,
            //* donc une autre route via la méthode redirectToRoute()
            //* Cette méthode attend 2 arguments
            //? 1. La route
            //? 2. le paramètre a transmettre dans la route, dans notre cas l'ID de l'article
            return $this->redirectToRoute('blog_show', [
                'id' => $article->getId()
            ]);
        }

        //* La classe Request permet de stocker et d'avoir accès aux données véhiculées par les superglobales
        //? ($_POST, $_GET, $_COOKIE, $_FILES, ect...)

        // return $this->render('blog/create_old.html.twig');
        return $this->render('blog/create.html.twig');
    }


    /**
     * Méthode permettant d'afficher le détail d'un article
     * 
     * @Route("/blog/new", name="blog_create")
     * @Route("/blog/{id}/edit", name="blog_edit")
     */
    public function create(Article $article = null, Request $request, EntityManagerInterface $manager): Response
    {
        //* Si la variable $article N'EST PAS (null), si elle ne contient aucun article de la BDD,
        //* cela veut dire nous avons envoyé la route '/blog/new',
        //* c'est une insertion, on entre dans le IF et on crée une nouvelle instance de l'entité Article, création d'un nouvel article
        //* Si la variable $article contient un article de la BDD, cela veut dire que nous avons envoyé la route '/blog/id/edit',
        //* c'est une modifiction d'article, on entre pas dans le IF, $article ne sera pas null,
        //* il contient un article de la BDD, l'article à modifier
        if(!$article)
        {
            $article = new Article;
        }
        // $article = new Article;

        //TODO TEST [réremplie le formulaire]
        //* En renseignant les setteurs  de l'entité, on s'aperçoit que les valeurs sont évnoyés directement dans
        //* ls attributs 'value' du formulaire, cela est dû au fait que l'entité $article est relié au formulaire
        //  $article->setTitre("Titre bidon")
        //          ->setContenu("Contenu bidon");

        // dump($request); //! ajouté avec (Request $request) après fonctionnement valable, ça récupère les données saisies du form
        //! permet donc de réintroduire les données dans le form

        //* createForm() permet ici de créer un formulaire d'ajout d'article en fonction de la classe ArticleType
        //* En 2eme argument de createForm(), nous transmettons l'objet entité $article afin de préciser
        //* que le formulaire a pour but de remplir l'objet $article, on relie l'entité au formulaire
        //! importer ArticleType, class crée pour un formulaire sur la table Article
        $formArticle = $this->createForm(ArticleType::class, $article);

        //* handleRequest() permet ici dans notre cas, de récupérer toute les données saisie dans le formulaire et de les transmetre aux bon seteurs de l'entité $article
        //* handleRequest() renseigne chaque setteur de l'entité $article avec les données saisi dans le formulaire
        $formArticle->handleRequest($request); //! et avec les données récup il va les binder directement dans les bon setter de l'objet
        //! non possible dans la version create_old

        // dump($article);

        //* Si le formulaire a bien été validé && que toute les données saisie sont bien transmise à la bonne entité,
        //* alors on entre dans la condition IF
        if($formArticle->isSubmitted() && $formArticle->isValid())
        {
            // on renseigne le setteur de la date, puisque nous n'avons pas de champ 'date' dans le formulaire
            // Si l'article ne possède pas d'ID, alors on entre dans la condition IF et on execute le setteur de la date, on entre dans le IF que dans le cas de la création d'un nouvel article
            if(!$article->getId())
            {
                $article->setDate(new \DateTime());
            }

            $manager->persist($article);

            $manager->flush();

            //!\\ arrivé là on reste sur la page avec les champs préremplie de ce qu'on vient de renseigner,
            //! cependant avec la commande qui suit on sera auto redirigé après post

            return $this->redirectToRoute('blog_show', [
                'id' => $article->getId()
            ]);
        }

        return $this->render('blog/create.html.twig', [
            'formArticle' => $formArticle->createView(),
            //? on transmet le formulaire au template afin de pouvoir l'afficher avec TWIG
            //* createView() va retourner un petit objet qui représente l'affichage du formulaire,
            //* on le récupère dans le template create.html.twig
            'editMode' => $article->getId() // on transmet l'id de l'article au template
        ]);
    }


    /**
     * Méthode permettant d'afficher le détail d'un article
     * 
     * @Route("/blog/{id}", name="blog_show")
     */
    // public function show(ArticleRepository $reportArticle, $id): Response
    public function show(Article $article, Request $request, EntityManagerInterface $manager): Response
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

        //* TRAITEMENT COMMENTAIRE ARTICLE (forulaire + insertion)
        $comment = new Comment;

        $formComment = $this->createForm(CommentType::class, $comment);

        // dump($request);

        $formComment->handleRequest($request);

        // dump($request);

        if($formComment->isSubmitted() && $formComment->isValid())
        {
            $comment->setDate(new \DateTime());

            //* On établit la relation entre le commentaire et l'article (clé étrangère)
            //* setArticle() : méthode issue de l'entité Comment qui permet de renseigner l'article associé au commentaire
            //* Cette méthode attends en argument l'objet entité Article de la BDD et non la clé étrangère elle même
            $comment->setArticle($article);

            $manager->persist($comment);
            $manager->flush();

            //? addFlash() : méthode permettant de déclarer un message de validation stocké en session
            // arguments :
            // 1. Identifiant du message (sucess / danger)
            // 2. Le message utilisateur
            $this->addFlash(
                'success',
                'Votre commentaire a bien été posté !'
            );

            /*
                session
                array(
                    success => [
                        0 => "Le commentaire a été posté avec succès !"
                    ]
                )
            */

            // dump($comment);

            //* Après l'insertion, on redirige l'internaute vers l'affichage de l'article afin de rebooter le formulaire
            return $this->redirectToRoute('blog_show', [
                'id' => $article->getId()
            ]);
        }


        return $this->render('blog/show.html.twig', [
            'articleBDD' => $article,
            //* on transmet au template les données de l'article selectionné en BDD afin de lestraiter avec le langage Twig dans le template 
            'formComment' => $formComment->createView()
        ]);
    }

}
