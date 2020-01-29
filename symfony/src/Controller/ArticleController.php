<?php


namespace App\Controller;


use App\Entity\Article;
use App\Entity\Category;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    public function homepage(ArticleRepository $repository, EntityManagerInterface $em)
    {
        $articles = $repository->findAllPublishedOrderedByNewest();

        return $this->render('home.html.twig', [
            'articles' => $articles,
            'archives' => $this->archivesByDateDesc($em),
            'categories' => $this->categoriesAlpha($em),
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

        return $this->render('article/show.html.twig', [
            'article' => $article,
            'mak' => $articleContent,
            'archives' => $this->archivesByDateDesc($em),
            'categories' => $this->categoriesAlpha($em),
        ]);
    }


    public function archivesByDateDesc(EntityManagerInterface $em)
    {
        $repository = $em->getRepository(Article::class);
        /** @var Artcile $articles */
        return $repository->findAllPublishedOrderedByNewest();
    }

    public function categoriesAlpha(EntityManagerInterface $em) {
        $repository = $em->getRepository(Category::class);
        return $repository->findAllByNameOrderedAsc();

    }
}