<?php

namespace App\Repository;

use App\Entity\EventProfileFeilds;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EventProfileFeilds|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventProfileFeilds|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventProfileFeilds[]    findAll()
 * @method EventProfileFeilds[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventProfileFeildsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventProfileFeilds::class);
    }

    // /**
    //  * @return EventProfileFeilds[] Returns an array of EventProfileFeilds objects
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
    public function findOneBySomeField($value): ?EventProfileFeilds
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
