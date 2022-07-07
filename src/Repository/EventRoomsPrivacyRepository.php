<?php

namespace App\Repository;

use App\Entity\EventRoomsPrivacy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EventRoomsPrivacy|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventRoomsPrivacy|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventRoomsPrivacy[]    findAll()
 * @method EventRoomsPrivacy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRoomsPrivacyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventRoomsPrivacy::class);
    }

    // /**
    //  * @return EventRoomsPrivacy[] Returns an array of EventRoomsPrivacy objects
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
    public function findOneBySomeField($value): ?EventRoomsPrivacy
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
