<?php

namespace App\Repository;

use App\Entity\EventTypes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EventTypes|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventTypes|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventTypes[]    findAll()
 * @method EventTypes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventTypesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventTypes::class);
    }

    // /**
    //  * @return EventTypes[] Returns an array of EventTypes objects
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
    public function findOneBySomeField($value): ?EventTypes
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
