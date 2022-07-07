<?php

namespace App\Repository;

use App\Entity\RoomSessionAccess;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RoomSessionAccess|null find($id, $lockMode = null, $lockVersion = null)
 * @method RoomSessionAccess|null findOneBy(array $criteria, array $orderBy = null)
 * @method RoomSessionAccess[]    findAll()
 * @method RoomSessionAccess[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoomSessionAccessRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RoomSessionAccess::class);
    }

    // /**
    //  * @return RoomSessionAccess[] Returns an array of RoomSessionAccess objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RoomSessionAccess
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
