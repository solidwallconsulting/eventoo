<?php

namespace App\Repository;

use App\Entity\StandConfigurations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StandConfigurations|null find($id, $lockMode = null, $lockVersion = null)
 * @method StandConfigurations|null findOneBy(array $criteria, array $orderBy = null)
 * @method StandConfigurations[]    findAll()
 * @method StandConfigurations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StandConfigurationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StandConfigurations::class);
    }

    // /**
    //  * @return StandConfigurations[] Returns an array of StandConfigurations objects
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
    public function findOneBySomeField($value): ?StandConfigurations
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
