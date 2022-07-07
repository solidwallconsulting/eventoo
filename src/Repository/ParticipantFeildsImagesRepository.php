<?php

namespace App\Repository;

use App\Entity\ParticipantFeildsImages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ParticipantFeildsImages|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParticipantFeildsImages|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParticipantFeildsImages[]    findAll()
 * @method ParticipantFeildsImages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParticipantFeildsImagesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParticipantFeildsImages::class);
    }

    // /**
    //  * @return ParticipantFeildsImages[] Returns an array of ParticipantFeildsImages objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ParticipantFeildsImages
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
