<?php

namespace App\Repository;

use App\Entity\EventRooms;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EventRooms|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventRooms|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventRooms[]    findAll()
 * @method EventRooms[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRoomsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventRooms::class);
    }

    // /**
    //  * @return EventRooms[] Returns an array of EventRooms objects
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
    public function findOneBySomeField($value): ?EventRooms
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
