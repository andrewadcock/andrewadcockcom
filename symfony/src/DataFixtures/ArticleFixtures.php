<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'main_articles', function($count) use ($manager) {
            $article = new Article();
            $article->setTitle($this->faker->text('40'))
                ->setSlug("test-article-" . $count)
                ->setContent($this->faker->text('2000'))
                ->setAuthor('Andrew Adcock')
                ->setImageFilename('code2.png')
                ->setPublished($this->faker->boolean(75));

            $date = new \DateTime();
//        $article->setPublishedAt($date->modify('+1 minutes'));
            $article->setPublishedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            
            return $article;
        });

        $manager->flush();
    }
}
