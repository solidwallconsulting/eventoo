<?php

namespace App\Repository;

use App\Entity\StandCatalogue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StandCatalogue|null find($id, $lockMode = null, $lockVersion = null)
 * @method StandCatalogue|null findOneBy(array $criteria, array $orderBy = null)
 * @method StandCatalogue[]    findAll()
 * @method StandCatalogue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StandCatalogueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StandCatalogue::class);
    }

    // /**
    //  * @return StandCatalogue[] Returns an array of StandCatalogue objects
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
    public function findOneBySomeField($value): ?StandCatalogue
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
