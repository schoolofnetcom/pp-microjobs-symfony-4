<?php

namespace App\Repository;

use App\Entity\Contratacoes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Contratacoes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contratacoes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contratacoes[]    findAll()
 * @method Contratacoes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContratacoesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Contratacoes::class);
    }

//    /**
//     * @return Contratacoes[] Returns an array of Contratacoes objects
//     */
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
    public function findOneBySomeField($value): ?Contratacoes
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
