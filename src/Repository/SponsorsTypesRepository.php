<?php

namespace App\Repository;

use App\Entity\SponsorsTypes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SponsorsTypes|null find($id, $lockMode = null, $lockVersion = null)
 * @method SponsorsTypes|null findOneBy(array $criteria, array $orderBy = null)
 * @method SponsorsTypes[]    findAll()
 * @method SponsorsTypes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SponsorsTypesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SponsorsTypes::class);
    }

    // /**
    //  * @return SponsorsTypes[] Returns an array of SponsorsTypes objects
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
    public function findOneBySomeField($value): ?SponsorsTypes
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
