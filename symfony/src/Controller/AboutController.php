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
        $articles = new ArticleController();
        $categories = $articles->categoriesAlpha($em);

        $archives = $articles->archivesByDateDesc($em);

        return $this->render('single/about.html.twig', [
            'categories' => $categories,
            'archives' => $archives
        ]);
    }
}