<?php

namespace App\Repository;

use App\Entity\EventsDurations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EventsDurations|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventsDurations|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventsDurations[]    findAll()
 * @method EventsDurations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventsDurationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventsDurations::class);
    }

    // /**
    //  * @return EventsDurations[] Returns an array of EventsDurations objects
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
    public function findOneBySomeField($value): ?EventsDurations
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
