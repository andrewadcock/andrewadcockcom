<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(Article::class, 10, function(Article $article, $count) {

            $article->setTitle("Test Article")
                ->setSlug("test-article-" . $count)
                ->setContent("Here is some content that is new and tomorrow")
                ->setAuthor('Andrew Adcock')
                ->setImageFilename('code2.png');

            $date = new \DateTime();
//        $article->setPublishedAt($date->modify('+1 minutes'));
            $article->setPublishedAt($date);

        });

        $manager->flush();
    }
}
