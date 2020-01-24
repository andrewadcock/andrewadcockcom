<?php


namespace App\Controller;


use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleAdminController extends AbstractController
{

    /**
     * @Route("/admin/article/new", name="article_new")
     */
    public function new(EntityManagerInterface $em)
    {
        $article = new Article();

        $article->setTitle("Test Article")
            ->setSlug("test-article-".rand(100, 999))
            ->setContent("Here is some content that is new and tomorrow")
            ->setAuthor('Andrew Adcock')
            ->setImageFilename('code2.png');

        $date = new \DateTime();
        $article->setPublishedAt($date->modify('+1 minutes'));

        $em->persist($article);
        $em->flush();

        return new Response(sprintf(
            'New article created: #%d slug: %s',
            $article->getId(),
            $article->getSlug()
        ));
    }
}