<?php

namespace App\DataFixtures;

use App\Entity\Ingredient;
use App\Entity\Recipe;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{

    /**
     * Undocumented variable
     *
     * @var Generator
     */
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }


    public function load(ObjectManager $manager): void
    {
        // Ingredients
        $ingrediants = [];
        for ($i=1; $i <= 50; $i++)
        {
            $ingredient = new Ingredient();

            $ingredient->setName($this->faker->word())  // word() génère un mot aléatoire de type string    
                                                        // OU      words()  génère un tableau (ou non) avec un nombre de mots aléatoires
                                                        // Exemple 1 : $faker->words(5);  ==> ['molestias', 'repellendus', 'qui', 'temporibus', 'ut']
                                                        // Exemple 2 : $faker->words(3, true);  ==> 'placeat vero saepe'  
                                                        // ici le fait de rajouter "true" génère 3 mots mais pas de tableau
                       ->setPrice(mt_rand(0, 100));  // mt_rand(int $min, int $max)  --> Génere un nombre entier aléatoirement

            $ingredients[] = $ingredient;
            $manager->persist($ingredient);  // persist() Ajoute un objet à la DB
        }

        //Recipes
        for ($j = 0; $j < 25; $j++)
        {
            $recipe = new Recipe();
            $recipe->setName($this->faker->word())
            ->setTime(mt_rand(0, 1) == 1 ? mt_rand(1, 1440) : null)
            ->setNbPeople(mt_rand(0, 1) == 1 ? mt_rand(1, 50) : null) 
            ->setDifficulty(mt_rand(0, 1) == 1 ? mt_rand(1, 5) : null)
            ->setDescription($this->faker->text(300))
            ->setPrice(mt_rand(0, 1) == 1 ? mt_rand(1, 1000) : null)
            ->setIsFavorite(mt_rand(0, 1) == 1 ? true : false);
        
            for ($k = 0; $k < \mt_rand(5, 15); $k++)
            {
                $recipe->addIngredient($ingredients[mt_rand(0, count($ingredients) - 1)]);
            }

            $manager->persist($recipe);

        }

        $manager->flush();    // flush() Execute toutes les commandes précédentes
    }
}
