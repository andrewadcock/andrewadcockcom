<?php


namespace App\Controller;


use App\Entity\Article;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Michelf\MarkdownInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{

    /**
     * @Route("/category/{slug}", name="category_show")
     */
    public function show($slug, EntityManagerInterface $em, MarkdownInterface $markdown)
    {
        // Get Repo
        $repository = $em->getRepository(Category::class);

        // Get category
        /** @var Category $category */
        $category = $repository->findOneBy(['slug' => $slug]);


        if(!$category) {
            throw $this->createNotFoundException(sprintf('Oops! No articles found in category: %s', $slug));
        }

        // Get articles
        $articleRepo = $em->getRepository(Article::class);
        $articles = $articleRepo->findByCategory($category);


        $archiveController = new ArticleController();
        $archives = $archiveController->archivesByDateDesc($em);

        return $this->render('category/show.html.twig', [
            'category' => $category,
            'articles' => $articles,
            'categories' => $this->categoriesAlpha($em),
            'archives' => $archives,
        ]);
    }

    public function categoriesAlpha(EntityManagerInterface $em) {
        $repository = $em->getRepository(Category::class);
        return $repository->findAllByNameOrderedAsc();

    }

}