<?php

namespace App\Repository;

use App\Entity\CategoryBudget;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategoryBudget|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryBudget|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryBudget[]    findAll()
 * @method CategoryBudget[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryBudgetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryBudget::class);
    }

    // /**
    //  * @return CategoryBudget[] Returns an array of CategoryBudget objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CategoryBudget
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
