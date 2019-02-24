<?php

namespace App\Repository;

use App\Entity\PaperFormat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PaperFormat|null find($id, $lockMode = null, $lockVersion = null)
 * @method PaperFormat|null findOneBy(array $criteria, array $orderBy = null)
 * @method PaperFormat[]    findAll()
 * @method PaperFormat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaperFormatRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PaperFormat::class);
    }

    // /**
    //  * @return PaperFormat[] Returns an array of PaperFormat objects
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
    public function findOneBySomeField($value): ?PaperFormat
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
