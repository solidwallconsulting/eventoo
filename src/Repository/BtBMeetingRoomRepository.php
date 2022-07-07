<?php

namespace App\Repository;

use App\Entity\BtBMeetingRoom;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BtBMeetingRoom|null find($id, $lockMode = null, $lockVersion = null)
 * @method BtBMeetingRoom|null findOneBy(array $criteria, array $orderBy = null)
 * @method BtBMeetingRoom[]    findAll()
 * @method BtBMeetingRoom[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BtBMeetingRoomRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BtBMeetingRoom::class);
    }

    // /**
    //  * @return BtBMeetingRoom[] Returns an array of BtBMeetingRoom objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BtBMeetingRoom
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
