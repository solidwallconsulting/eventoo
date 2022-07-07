<?php

namespace App\Repository;

use App\Entity\BtBMeetingRoomType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BtBMeetingRoomType|null find($id, $lockMode = null, $lockVersion = null)
 * @method BtBMeetingRoomType|null findOneBy(array $criteria, array $orderBy = null)
 * @method BtBMeetingRoomType[]    findAll()
 * @method BtBMeetingRoomType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BtBMeetingRoomTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BtBMeetingRoomType::class);
    }

    // /**
    //  * @return BtBMeetingRoomType[] Returns an array of BtBMeetingRoomType objects
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
    public function findOneBySomeField($value): ?BtBMeetingRoomType
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
