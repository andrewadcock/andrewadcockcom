<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends AbstractController
{

    /**
     * @Route("/about", name="app_about")
     */
    public function show(EntityManagerInterface $em)
    {
        $cats = new CategoryController();
        $categories = $cats->categoriesAlpha($em);


        $articles = new ArticleController();
        $archives = $articles->archivesByDateDesc($em);

        return $this->render('single/about.html.twig', [
            'categories' => $categories,
            'archives' => $archives
        ]);
    }
}