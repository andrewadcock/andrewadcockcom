<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i = 0; $i < 10; $i++) {
            $article = new Article();

            $article->setTitle("Test Article")
                ->setSlug("test-article-" . rand(100, 999))
                ->setContent("Here is some content that is new and tomorrow")
                ->setAuthor('Andrew Adcock')
                ->setImageFilename('code2.png');

            $date = new \DateTime();
//        $article->setPublishedAt($date->modify('+1 minutes'));
            $article->setPublishedAt($date);

            $manager->persist($article);
        }
        $manager->flush();
    }
}
