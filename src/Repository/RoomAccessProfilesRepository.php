<?php

namespace App\Repository;

use App\Entity\RoomAccessProfiles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RoomAccessProfiles|null find($id, $lockMode = null, $lockVersion = null)
 * @method RoomAccessProfiles|null findOneBy(array $criteria, array $orderBy = null)
 * @method RoomAccessProfiles[]    findAll()
 * @method RoomAccessProfiles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoomAccessProfilesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RoomAccessProfiles::class);
    }

    // /**
    //  * @return RoomAccessProfiles[] Returns an array of RoomAccessProfiles objects
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
    public function findOneBySomeField($value): ?RoomAccessProfiles
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
