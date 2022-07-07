<?php

namespace App\Repository;

use App\Entity\EventStands;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EventStands|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventStands|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventStands[]    findAll()
 * @method EventStands[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventStandsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventStands::class);
    }

    // /**
    //  * @return EventStands[] Returns an array of EventStands objects
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
    public function findOneBySomeField($value): ?EventStands
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
