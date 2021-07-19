<?php


namespace App\DataFixtures;


use Faker\Factory;
use App\Entity\Tag;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class TagFixtures extends Fixture
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        # Création de notre instance de Faker
        $faker = \Faker\Factory::create('fr_FR');
        // $faker = FACTORY::create('fr_FR');

        # Génération de 10 tags aléatoire
        for($i = 1; $i <= 10 ; $i++)
        {
            # Création d'un Tag aléatoire
            $tag = new Tag();
            $tag->setTitle($faker->word);

            # Sauvegarde dans la BDD
            $manager->persist($tag);
        }

        # Execution des requètes de sauvegarde.
        $manager->flush();

    }
}
