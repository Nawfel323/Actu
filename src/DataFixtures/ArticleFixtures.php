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
                ->setContent("<p>Contenu n°$i</p>")
                ->setImage("http://placehold.it/450x200")
                ->setCreatedAt(new \DateTime());




            //prépare les articles a "persister"  dans le temps
            $manager->persist($article);
        }

        //Les artciles sont désormais existant dans la bdd
        $manager->flush();
    }
}
