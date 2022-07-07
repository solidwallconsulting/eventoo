<?php

namespace App\Repository;

use App\Entity\MeetingSessions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MeetingSessions|null find($id, $lockMode = null, $lockVersion = null)
 * @method MeetingSessions|null findOneBy(array $criteria, array $orderBy = null)
 * @method MeetingSessions[]    findAll()
 * @method MeetingSessions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MeetingSessionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MeetingSessions::class);
    }

    // /**
    //  * @return MeetingSessions[] Returns an array of MeetingSessions objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MeetingSessions
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
