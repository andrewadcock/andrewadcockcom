<?php


namespace App\Controller;


use App\Entity\Article;
use App\Entity\Category;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Michelf\MarkdownInterface;
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
    public function homepage(ArticleRepository $repository, EntityManagerInterface $em, MarkdownParserInterface $markdownParser)
    {
        $articles = $repository->findAllPublishedOrderedByNewest();

        $cats = new CategoryController();
        $categories = $cats->categoriesAlpha($em);

        return $this->render('home.html.twig', [
            'articles' => $articles,
            'archives' => $this->archivesByDateDesc($em),
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/blog/{slug}", name="article_show")
     */
    public function show($slug, EntityManagerInterface $em, MarkdownInterface $markdown)
    {
        // Get Repo
        $repository = $em->getRepository(Article::class);

        // Get article
        /** @var Article $article */
        $article = $repository->findOneBy(['slug' => $slug]);
        $articleContent = $markdown->transform($article->getContent());



        if(!$article) {
            throw $this->createNotFoundException(sprintf('Oops! No article, %s,found', $slug));
        }

        $cats = new CategoryController();
        $categories = $cats->categoriesAlpha($em);

        return $this->render('article/show.html.twig', [
            'article' => $article,
            'articleContent' => $articleContent,
            'archives' => $this->archivesByDateDesc($em),
            'categories' => $categories,
        ]);
    }


    public function archivesByDateDesc(EntityManagerInterface $em)
    {
        $repository = $em->getRepository(Article::class);
        /** @var Artcile $articles */
        return $repository->findAllPublishedOrderedByNewest();
    }
}