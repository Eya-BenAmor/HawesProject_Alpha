<?php

namespace App\Repository;

use App\Entity\Participant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Participant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Participant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Participant[]    findAll()
 * @method Participant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParticipantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Participant::class);
    }

    // /**
    //  * @return Participant[] Returns an array of Participant objects
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
    public function findOneBySomeField($value): ?Participant
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function showByUser($id)
    {
        return $this->createQueryBuilder('p')
               ->join('p.user', 'c')
            ->addSelect('c')
            ->where('c.id LIKE :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult()
        ;
    }




    public function showByRandonnee($id)
    {
        return $this->createQueryBuilder('p')
               ->join('p.randonnee', 'r')
            ->addSelect('r')
            ->where('r.id LIKE :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult()
        ;
    }


    

   
}
