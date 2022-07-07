<?php

namespace App\Repository;

use App\Entity\MailTypes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MailTypes|null find($id, $lockMode = null, $lockVersion = null)
 * @method MailTypes|null findOneBy(array $criteria, array $orderBy = null)
 * @method MailTypes[]    findAll()
 * @method MailTypes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MailTypesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MailTypes::class);
    }

    // /**
    //  * @return MailTypes[] Returns an array of MailTypes objects
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
    public function findOneBySomeField($value): ?MailTypes
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
