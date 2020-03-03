<?php
// src/DataFixtures/FakerFixtures.php
namespace App\DataFixtures;

use App\Entity\Bouquet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class FakerFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');

        // on créé 10 personnes
        for ($i = 0; $i < 100; $i++) {
            $personne = new Bouquet();
            $personne->setNom($faker->word);
            $personne->setPrix($faker->randomNumber(2));
            $personne->setStyle($faker->word);
            $personne->setComposition($faker->sentence($nbWords = 3, $variableNbWords = true));
            $manager->persist($personne);
        }

        $manager->flush();
    }
}