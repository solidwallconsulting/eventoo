<?php

namespace App\Repository;

use App\Entity\EventProfileFeildValue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EventProfileFeildValue|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventProfileFeildValue|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventProfileFeildValue[]    findAll()
 * @method EventProfileFeildValue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventProfileFeildValueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventProfileFeildValue::class);
    }

    // /**
    //  * @return EventProfileFeildValue[] Returns an array of EventProfileFeildValue objects
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
    public function findOneBySomeField($value): ?EventProfileFeildValue
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
