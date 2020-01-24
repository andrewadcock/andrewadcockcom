<?php


namespace App\Controller;


use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{

    /**
     * @Route("/", name="app_homepage")
     * @return Response
     * @throws \Exception
     */
    public function homepage(ArticleRepository $repository)
    {
        $articles = $repository->findAllPublishedOrderedByNewest();

        return $this->render('home.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/blog/{slug}", name="article_show")
     */
    public function show($slug, EntityManagerInterface $em)
    {
        // Get Repo
        $repository = $em->getRepository(Article::class);

        // Get article
        /** @var Article $article */
        $article = $repository->findOneBy(['slug' => $slug]);

        if(!$article) {
            throw $this->createNotFoundException(sprintf('Oops! No article, %s,found', $slug));
        }

        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }
}