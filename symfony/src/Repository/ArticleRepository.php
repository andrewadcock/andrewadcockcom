<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * @return Article[] Returns an array of articles
     * @throws \Exception
     */
    public function findAllPublishedOrderedByNewest()
    {;

        $qb = $this->createQueryBuilder('a');

        return $this->isPublishedQueryBuilder($qb)
            ->orderBy('a.publishedAt', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();

    }

    private function isPublishedQueryBuilder(QueryBuilder $qb)
    {
        return $qb->andWhere('a.publishedAt IS NOT NULL')
        ->andWhere('a.publishedAt < :val')
        ->setParameter('val', new \DateTime());
    }

    public function findByCategory(string $categoryId)
    {
        // TODO: Get all articles in category
        $qb = $this->createQueryBuilder('a');
        return $qb->andWhere('a.categories = :val')
            ->setParameter('val', $categoryId);
    }
}
