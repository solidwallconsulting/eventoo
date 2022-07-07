<?php

namespace App\Repository;

use App\Entity\RoomProgramm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RoomProgramm|null find($id, $lockMode = null, $lockVersion = null)
 * @method RoomProgramm|null findOneBy(array $criteria, array $orderBy = null)
 * @method RoomProgramm[]    findAll()
 * @method RoomProgramm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoomProgrammRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RoomProgramm::class);
    }

    // /**
    //  * @return RoomProgramm[] Returns an array of RoomProgramm objects
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
    public function findOneBySomeField($value): ?RoomProgramm
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
