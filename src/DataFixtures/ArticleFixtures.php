<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ArticleFixtures extends Fixture
{


    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');


        //3 catégories par fake
        for ($i = 1; $i <= 3; $i++) {
            $category = new Category();

            $category->setTitle($faker->sentence)
                ->setDescription($faker->paragraph());


            $manager->persist($category);

            //créer 4 et 6 articles env
            //incrémentation de (fausses données) pour les articles
            for ($j = 1; $j <= mt_rand(4, 6); $j++) {


                //$content = '<p>' . join($faker->paragraphs(1)) . '</p>';

                $article = new Article;
                $article->setTitle($faker->sentence())
                    ->setContent("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum eros dolor,
                     dignissim vel ex consectetur, varius feugiat diam. Sed ornare in arcu vitae sagittis. 
                     Integer enim justo, pulvinar eget elit at, imperdiet efficitur ante. Suspendisse vel tempus ante, non congue sapien.
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum et sapien nulla.") //or $content
                    ->setImage("http://placehold.it/450x200") //or $faker->imageUrl()
                    ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                    ->setCategory($category);

                //prépare les articles a "persister"  dans le temps
                $manager->persist($article);
            }
        }
        //Les artciles sont désormais existant dans la bdd
        $manager->flush();
    }
}
