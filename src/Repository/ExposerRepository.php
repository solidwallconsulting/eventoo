<?php

namespace App\Repository;

use App\Entity\Exposer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Exposer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Exposer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Exposer[]    findAll()
 * @method Exposer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExposerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Exposer::class);
    }

    // /**
    //  * @return Exposer[] Returns an array of Exposer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Exposer
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
