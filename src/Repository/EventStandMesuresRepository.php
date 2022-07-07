<?php

namespace App\Repository;

use App\Entity\EventStandMesures;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EventStandMesures|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventStandMesures|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventStandMesures[]    findAll()
 * @method EventStandMesures[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventStandMesuresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventStandMesures::class);
    }

    // /**
    //  * @return EventStandMesures[] Returns an array of EventStandMesures objects
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
    public function findOneBySomeField($value): ?EventStandMesures
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
