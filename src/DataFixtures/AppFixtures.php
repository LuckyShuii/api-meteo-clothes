<?php

namespace App\DataFixtures;

use App\Entity\Clothe;
use App\Entity\ClotheType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        // Using Faker to generate random data
        $faker = Factory::create();

        // Create 3 clothe types with predefined names and temperatures
        $typesData = [
            ['name' => 'pull', 'temperature' => 'cold'],
            ['name' => 'sweat', 'temperature' => 'medium'],
            ['name' => 't-shirt', 'temperature' => 'hot'],
        ];

        $clotheTypes = [];

        // Persisting clothe types
        foreach ($typesData as $data) {
            $type = new ClotheType();
            $type->setName($data['name']);
            $type->setTemperature($data['temperature']);
            $manager->persist($type);
            $clotheTypes[] = $type;
        }

        // Creating 5 clothes for each type, with random names and prices
        foreach ($clotheTypes as $type) {
            for ($i = 0; $i < 5; $i++) {
                $clothe = new Clothe();
                $clothe->setName(ucfirst($faker->word()));
                $clothe->setPrice($faker->randomFloat(2, 10, 100)); // entre 10 et 100 €
                $clothe->setClotheType($type);
                $manager->persist($clothe);
            }
        }

        $manager->flush();
    }
}
