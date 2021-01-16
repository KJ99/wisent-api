<?php

namespace App\Repository;

use App\Entity\Dish;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Dish|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dish|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dish[]    findAll()
 * @method Dish[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DishRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dish::class);
    }

    public function findBySearchParams(array $params) {
        $qb = $this->createQueryBuilder('s');
        if(isset($params['id'])) {
            $qb
                ->andWhere('s.id = :id')
                ->setParameter('id', $params['id']);
        }
        if(isset($params['visible'])) {
            $qb
                ->andWhere('s.visible = :visible')
                ->setParameter('visible', $params['visible']);
        }
        if(isset($params['subcategory_id'])) {
            $qb
                ->andWhere('identity(s.subcategory) = :subcategory_id')
                ->setParameter('subcategory_id', $params['subcategory_id']);
        }
        return $qb->getQuery()->getResult();
    }

    // /**
    //  * @return Dish[] Returns an array of Dish objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Dish
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
