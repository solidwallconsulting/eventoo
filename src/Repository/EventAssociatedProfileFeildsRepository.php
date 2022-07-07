<?php

namespace App\Repository;

use App\Entity\EventAssociatedProfileFeilds;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EventAssociatedProfileFeilds|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventAssociatedProfileFeilds|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventAssociatedProfileFeilds[]    findAll()
 * @method EventAssociatedProfileFeilds[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventAssociatedProfileFeildsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventAssociatedProfileFeilds::class);
    }

    // /**
    //  * @return EventAssociatedProfileFeilds[] Returns an array of EventAssociatedProfileFeilds objects
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
    public function findOneBySomeField($value): ?EventAssociatedProfileFeilds
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
