<?php

namespace App\Repository;

use App\Entity\OrderRules;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrderRules|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderRules|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderRules[]    findAll()
 * @method OrderRules[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRulesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderRules::class);
    }

    // /**
    //  * @return OrderRules[] Returns an array of OrderRules objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OrderRules
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
