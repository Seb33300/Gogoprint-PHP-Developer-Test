<?php

namespace App\Repository;

use App\Entity\ProductionTimeMarkup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProductionTimeMarkup|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductionTimeMarkup|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductionTimeMarkup[]    findAll()
 * @method ProductionTimeMarkup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductionTimeMarkupRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProductionTimeMarkup::class);
    }

    // /**
    //  * @return ProductionTimeMarkup[] Returns an array of ProductionTimeMarkup objects
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
    public function findOneBySomeField($value): ?ProductionTimeMarkup
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
