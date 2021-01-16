<?php

namespace App\Repository;

use App\Entity\Subcategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Subcategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method Subcategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method Subcategory[]    findAll()
 * @method Subcategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubcategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Subcategory::class);
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
        if(isset($params['category_id'])) {
            $qb
                ->andWhere('identity(s.category) = :category_id')
                ->setParameter('category_id', $params['category_id']);
        }
        return $qb->getQuery()->getResult();
    }

    // /**
    //  * @return Subcategory[] Returns an array of Subcategory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Subcategory
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
