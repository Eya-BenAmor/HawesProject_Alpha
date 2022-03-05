<?php

namespace App\Repository;

use App\Entity\Cadeau;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query;


/**
 * @method Cadeau|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cadeau|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cadeau[]    findAll()
 * @method Cadeau[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CadeauRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cadeau::class);
    }


    
    
    // /**
    //  * @return Cadeau[] Returns an array of Cadeau objects
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
    public function findOneBySomeField($value): ?Cadeau
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
   


        public function findEntitiesByNom($nom){
            return $this->getEntityManager()
                ->createQuery(
                    'SELECT c
                    FROM App\Entity\Cadeau c
                    WHERE c.nom LIKE :nom'
                )
                ->setParameter('nom', '%'.$nom.'%')
                ->getResult();
        }



    public function findDocumeByIdCadeau($competition_id){

        return $this->createQueryBuilder('c')
        ->Where('c.competition =:competition')
        ->setParameter('competition',$competition_id)
        ->getQuery()
        ->getResult();
    }





}


