<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager as PersistenceObjectManager;
use Doctrine\Persistence\ObjectManagerAware;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
//use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;


class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(): Response
    {

        $repo = $this->getDoctrine()->getRepository(Article::class);

        //trouve tt les articles du repo
        $articles = $repo->findAll();

        //Trouve un article spécifique
        //$article = $repo->find(12);
        //$article = $repo->findOneByTitle('Titre');
        //$articles = $repo->findByTitle('Titre');

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles,
        ]);
    }
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('blog/home.html.twig', [
            'title' => "Titre récupérer",
        ]);
    }
    /**
     * @Route("/blog/new", name="blog_create")
     * @Route("/blog/{id}/edit", name="blog_edit" )
     */
    public function form(Article $article = null, Request $request, EntityManagerInterface $manager)
    {


        if (!$article) {
            $article = new Article();
        }

        $article->setTitle("Titre d'exemple")
            ->setContent("Le contenu de l'article");

        /*$form = $this->createFormBuilder($article)
            ->add('title')
            ->add('content')
            ->add('image')
            ->getForm();*/
        //récupére le formulaire déja crée en cli
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$article->getId()) {
                $article->setCreatedAt(new \DateTime());
            }

            //fait persister les données ephemeres dans le temps 
            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('blog_show', ['id' => $article->getId()]);
        }



        return $this->render('blog/create.html.twig', [
            'formArticle' => $form->createView(),
            'editMode' => $article->getId() !== null
        ]);
    }
    /**
     * @Route("/blog/{id}", name="blog_show")
     */
    public function Show($id)
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);

        $article = $repo->find($id);

        return $this->render('blog/show.html.twig', [
            'article' => $article,
        ]);
    }
}
