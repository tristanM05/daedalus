<?php

namespace App\Repository;

use App\Entity\Infocitygame;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Infocitygame|null find($id, $lockMode = null, $lockVersion = null)
 * @method Infocitygame|null findOneBy(array $criteria, array $orderBy = null)
 * @method Infocitygame[]    findAll()
 * @method Infocitygame[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InfocitygameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Infocitygame::class);
    }

    // /**
    //  * @return Infocitygame[] Returns an array of Infocitygame objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Infocitygame
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
