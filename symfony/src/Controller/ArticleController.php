<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{

    /**
     * @Route("/", name="app_homepage")
     * @return Response
     */
    public function homepage()
    {
        return $this->render('home.html.twig');
    }

    /**
     * @Route("/blog/{slug}")
     */
    public function show($slug)
    {
        return $this->render('article/show.html.twig');
    }
}