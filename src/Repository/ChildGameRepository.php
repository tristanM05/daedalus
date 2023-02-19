<?php

namespace App\Repository;

use App\Entity\ChildGame;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ChildGame|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChildGame|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChildGame[]    findAll()
 * @method ChildGame[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChildGameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChildGame::class);
    }

    // /**
    //  * @return ChildGame[] Returns an array of ChildGame objects
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
    public function findOneBySomeField($value): ?ChildGame
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
