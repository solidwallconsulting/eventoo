<?php

namespace App\Repository;

use App\Entity\NotesCategories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NotesCategories|null find($id, $lockMode = null, $lockVersion = null)
 * @method NotesCategories|null findOneBy(array $criteria, array $orderBy = null)
 * @method NotesCategories[]    findAll()
 * @method NotesCategories[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotesCategoriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NotesCategories::class);
    }

    // /**
    //  * @return NotesCategories[] Returns an array of NotesCategories objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NotesCategories
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
