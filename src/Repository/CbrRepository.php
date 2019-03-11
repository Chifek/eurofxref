<?php

namespace App\Repository;

use App\Entity\Cbr;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Cbr|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cbr|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cbr[]    findAll()
 * @method Cbr[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CbrRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Cbr::class);
    }

    // /**
    //  * @return Cbr[] Returns an array of Cbr objects
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
    public function findOneBySomeField($value): ?Cbr
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
