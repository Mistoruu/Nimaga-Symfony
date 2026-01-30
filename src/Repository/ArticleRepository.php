<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    //    /**
    //     * @return Article[] Returns an array of Article objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Article
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function findRecent(): array
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.createdAt', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }
    public function findPublished(): array
    {
        return $this->createQueryBuilder('a')
            ->where('a.published = 1')
            ->orderBy('a.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
    public function findByCategory($categoryId){
        $qb = $this->createQueryBuilder('a');
        $qb->leftJoin('a.category', 'c')
            ->where('c.id = :categoryId')
            ->setParameter('categoryId', $categoryId);
        return $qb->getQuery()->getResult();
    }

    public function findByAuthor($userId)
    {
        $qb = $this->createQueryBuilder('a');
        $qb->where('a.author = :userId')
            ->setParameter('userId', $userId);
        return $qb->getQuery()->getResult();
    }
    public function findAllWithAuthor()
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('a.author', 'u')
            ->addSelect('u')
            ->getQuery()
            ->getResult();
    }
    public function findAllWithAuthorQuery()
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('a.author', 'u')
            ->addSelect('u')
            ->getQuery();
    }
    public function search(array $criteria)
    {
        $qb = $this->createQueryBuilder('a')
            ->leftJoin('a.author', 'u')
            ->leftJoin('a.category', 'c')
            ->addSelect('u', 'c');

        // 01. Recherche par titre (LIKE)
        if (!empty($criteria['q'])) {
            $qb->andWhere('a.title LIKE :term')
                ->setParameter('term', '%' . $criteria['q'] . '%');
        }

        // 02. Filtre par catégorie
        if (!empty($criteria['category'])) {
            $qb->andWhere('c.id = :catId')
                ->setParameter('catId', $criteria['category']);
        }

        $qb->orderBy('a.createdAt');

        return $qb->getQuery();
    }

}
