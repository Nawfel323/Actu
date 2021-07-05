<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        //incrémentation de (fausses données) pour les articles
        for ($i = 1; $i <= 10; $i++) {
            # code...
            $article = new Article;
            $article->setTitle("Titre de l'article n°$i")
                ->setContent("<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a
                 galley of type and scrambled it to make a type specimen book. It has survived not only five centuries,
                  but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s 
                  with the release of Letraset sheets containing Lorem Ipsum passages,
                 and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>")
                ->setImage("http://placehold.it/450x200")
                ->setCreatedAt(new \DateTime());




            //prépare les articles a "persister"  dans le temps
            $manager->persist($article);
        }

        //Les artciles sont désormais existant dans la bdd
        $manager->flush();
    }
}
