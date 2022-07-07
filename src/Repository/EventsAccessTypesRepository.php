<?php

namespace App\Repository;

use App\Entity\EventsAccessTypes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EventsAccessTypes|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventsAccessTypes|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventsAccessTypes[]    findAll()
 * @method EventsAccessTypes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventsAccessTypesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventsAccessTypes::class);
    }

    // /**
    //  * @return EventsAccessTypes[] Returns an array of EventsAccessTypes objects
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
    public function findOneBySomeField($value): ?EventsAccessTypes
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
