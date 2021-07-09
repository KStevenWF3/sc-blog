<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Entity\Category;
use App\Entity\Comment;
use DateTime;

class ArticlesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        //TODO : https://github.com/fzaninotto/Faker
        //* On importe la librairie Faker pour les fixtures, cela nous permet de crée des fausses articles,
        //* catégories, commentaires plus évolués avec par exemple des faux noms, faux prénoms, date aléatoires ect...
        $faker = \Faker\Factory::create('fr_FR');

        //* Création de 3 catégories
        for($cat = 1; $cat <= 3; $cat++)
        {
            $category = new Category;

            $category->setTitre($faker->word)
                     ->setDescription($faker->paragraph()); // pas de s car 1 paragraphe

            $manager->persist($category);

            //* Creation de 4 à 10 articles par catégorie
            for($art = 1; $art <= mt_rand(4,10); $art++)
            {

                //! si la cmd "sc-blog> php bin/console doctrine:fixtures:load" donne :
                // Argument 1 passed to App\Entity\Article::setContenu() must be of the type string, array given, called in C:\xampp\htdocs\symfony\sc-blog\src\DataFixtures\ArticlesFixtures.php on line
                //! alors on ajoute $contenu
                //* 
                $contenu = '<p>' . join($faker->paragraphs(5), '</p><p>') . '</p>';

                $article = new Article;

                $article->setTitre($faker->sentence())
                        // ->setContenu($faker->paragraphs(5)) // s car plusieurs paragraphes //! $faker => $contenu
                        ->setContenu($contenu) //!\\
                        ->setImage($faker->imageUrl(600,600))
                        ->setDate($faker->dateTimeBetween('-6 months'))
                        ->setCategory($category); // l'objet complet dans Article.php

                $manager->persist($article);

                //* Création de 4 à 10 commentaire pour chaque article
                for($cmt = 1; $cmt <= mt_rand(4,10); $cmt++)
                {
                    $comment = new Comment;

                    $now = new DateTime;
                    $interval = $now->diff($article->getDate()); // retourne un timestamp (temps en secondes) entre la date de créations des articles et aujourd'hui

                    $days = $interval->days; // retourne le nombre de jour entre la date de création des articles et aujourd'hui

                    $minimum = "-$days days"; // -100 days | le but est d'avoir des dates de commentaires entre la date de création des articles et aujourd'hui

                    // TRAITEMENT DES PARAGRAPHES DE COMMENTAIRES
                    $contenu = '<p>' . join($faker->paragraphs(2), '</p><p>') . '</p>';

                    $comment->setAuteur($faker->name)
                            // ->setCommentaire($faker->paragraphs(2)) //!
                            ->setCommentaire($contenu)
                            ->setDate($faker->dateTimeBetween($minimum)) // dateTimeBetween(-10 days)
                            ->setArticle($article);

                    $manager->persist($comment);
                }
            }
        }

        $manager->flush();
    }
}
