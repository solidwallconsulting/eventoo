<?php

namespace App\Repository;

use App\Entity\SessionMeetings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SessionMeetings|null find($id, $lockMode = null, $lockVersion = null)
 * @method SessionMeetings|null findOneBy(array $criteria, array $orderBy = null)
 * @method SessionMeetings[]    findAll()
 * @method SessionMeetings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionMeetingsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SessionMeetings::class);
    }

    // /**
    //  * @return SessionMeetings[] Returns an array of SessionMeetings objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SessionMeetings
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
