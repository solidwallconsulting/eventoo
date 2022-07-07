<?php

namespace App\Repository;

use App\Entity\StandProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StandProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method StandProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method StandProduct[]    findAll()
 * @method StandProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StandProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StandProduct::class);
    }

    // /**
    //  * @return StandProduct[] Returns an array of StandProduct objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StandProduct
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
