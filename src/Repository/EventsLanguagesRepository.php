<?php

namespace App\Repository;

use App\Entity\EventsLanguages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EventsLanguages|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventsLanguages|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventsLanguages[]    findAll()
 * @method EventsLanguages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventsLanguagesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventsLanguages::class);
    }

    // /**
    //  * @return EventsLanguages[] Returns an array of EventsLanguages objects
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
    public function findOneBySomeField($value): ?EventsLanguages
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
