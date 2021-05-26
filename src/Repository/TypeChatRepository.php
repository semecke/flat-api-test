<?php

namespace App\Repository;

use App\Entity\TypeChat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TypeChat|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeChat|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeChat[]    findAll()
 * @method TypeChat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeChatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeChat::class);
    }

    // /**
    //  * @return TypeChat[] Returns an array of TypeChat objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeChat
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
