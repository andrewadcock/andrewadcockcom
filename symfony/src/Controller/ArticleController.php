<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController
{

    /**
     * @Route("/", name="app_homepage")
     * @return Response
     */
    public function homepage()
    {
        return new Response('Homepage');
    }

    /**
     * @Route("/blog/{slug}")
     */
    public function show($slug)
    {
        return new Response(sprintf('Article: %s', $slug));
    }
}