<?php

namespace App\Repository;

use App\Entity\Randonnee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Randonnee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Randonnee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Randonnee[]    findAll()
 * @method Randonnee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RandonneeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Randonnee::class);
    }

    // /**
    //  * @return Randonnee[] Returns an array of Randonnee objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Randonnee
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function  showByCategorie1()
    {
        return $this->createQueryBuilder('r')
            ->where('r.categorieRando LIKE :categorie')
            ->setParameter('categorie', 'velo')
            ->getQuery()
            ->getResult()
        ;
    }
    public function  showByCategorie2()
    {
        return $this->createQueryBuilder('r')
            ->where('r.categorieRando LIKE :categorie')
            ->setParameter('categorie', 'voiture')
            ->getQuery()
            ->getResult()
        ;
    }
    public function  showByCategorie3()
    {
        return $this->createQueryBuilder('r')
            ->where('r.categorieRando LIKE :categorie')
            ->setParameter('categorie', 'pied')
            ->getQuery()
            ->getResult()
        ;
    }
}
