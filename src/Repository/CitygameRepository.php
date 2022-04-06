<?php

namespace App\Repository;

use App\Entity\Citygame;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Citygame|null find($id, $lockMode = null, $lockVersion = null)
 * @method Citygame|null findOneBy(array $criteria, array $orderBy = null)
 * @method Citygame[]    findAll()
 * @method Citygame[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CitygameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Citygame::class);
    }

    // /**
    //  * @return Citygame[] Returns an array of Citygame objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Citygame
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
