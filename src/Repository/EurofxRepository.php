<?php

namespace App\Repository;

use App\Entity\Eurofx;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Eurofx|null find($id, $lockMode = null, $lockVersion = null)
 * @method Eurofx|null findOneBy(array $criteria, array $orderBy = null)
 * @method Eurofx[]    findAll()
 * @method Eurofx[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EurofxRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Eurofx::class);
    }

    // /**
    //  * @return Eurofx[] Returns an array of Eurofx objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Eurofx
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
