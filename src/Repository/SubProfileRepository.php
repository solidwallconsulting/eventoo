<?php

namespace App\Repository;

use App\Entity\SubProfile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SubProfile|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubProfile|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubProfile[]    findAll()
 * @method SubProfile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubProfileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubProfile::class);
    }

    // /**
    //  * @return SubProfile[] Returns an array of SubProfile objects
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
    public function findOneBySomeField($value): ?SubProfile
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
