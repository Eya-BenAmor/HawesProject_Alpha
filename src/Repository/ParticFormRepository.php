<?php

namespace App\Repository;

use App\Entity\ParticForm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ParticForm|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParticForm|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParticForm[]    findAll()
 * @method ParticForm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParticFormRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParticForm::class);
    }

    // /**
    //  * @return ParticForm[] Returns an array of ParticForm objects
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
    public function findOneBySomeField($value): ?ParticForm
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
