<?php

namespace App\Repository;

use App\Entity\NoteObjet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method NoteObjet|null find($id, $lockMode = null, $lockVersion = null)
 * @method NoteObjet|null findOneBy(array $criteria, array $orderBy = null)
 * @method NoteObjet[]    findAll()
 * @method NoteObjet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NoteObjetRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, NoteObjet::class);
    }

    // /**
    //  * @return NoteObjet[] Returns an array of NoteObjet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NoteObjet
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}