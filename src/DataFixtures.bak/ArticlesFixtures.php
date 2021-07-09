<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ArticlesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        //* la boucle FOR tourne 10 fois car nous voulons 10 articles
        for($i = 1; $i <= 11; $i++)
        {
            /*
            *   Pour pouvoir insérer des données dans la table SQL article, nous devons instancier son entité correspondante (Article),
            *   Symfony se sert de l'objet entité $article pour injecter les valeurs dans la requete SQL
            */
            $article = new Article;

            //* On fait appel aux setteurs de l'objet entité afin de renseigner les titres, les contenu, les images et les dates des faux articles stockés en BDD
            $article->setTitre("Titre de l'article $i")
                    ->setContenu("<p>Sint id laboris anim mollit aliquip voluptate et in anim labore qui. Consectetur sint est quis velit ut amet ex eiusmod voluptate minim deserunt nulla. Mollit velit qui sint quis velit culpa consectetur in occaecat. Nulla incididunt qui mollit nisi.</p>")
                    ->setImage("https://picsum.photos/600/600")
                    ->setDate(new \DateTime());

            /*
            *   Un manager (ObjectManager) en symfony est une classe permettant, entre autre,
            *   de manipuler les lignes de la BDD (INSERT, UPDATE, DELETE)

            *   persist() : méthode issue de la classe ObjectManager permettant de préaprer et de garder en méméoire les requetes d'insertion
            ? $data = $bdd->prepare("INSERT INTO article VALUES ('getTitre()', 'getContenu()')") x 10
            */
            $manager->persist($article);
        }

        //* flush() : méthode issue de la classe ObjectManager permettant véritablement d'executer les requetes d'insertions en BDD
        $manager->flush(); //? execute()
    }
}
