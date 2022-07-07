<?php

namespace App\Repository;

use App\Entity\EventsAccessibility;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EventsAccessibility|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventsAccessibility|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventsAccessibility[]    findAll()
 * @method EventsAccessibility[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventsAccessibilityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventsAccessibility::class);
    }

    // /**
    //  * @return EventsAccessibility[] Returns an array of EventsAccessibility objects
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
    public function findOneBySomeField($value): ?EventsAccessibility
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
