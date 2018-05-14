<?php

namespace App\Repository;

use App\Entity\Servico;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Servico|null find($id, $lockMode = null, $lockVersion = null)
 * @method Servico|null findOneBy(array $criteria, array $orderBy = null)
 * @method Servico[]    findAll()
 * @method Servico[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServicoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Servico::class);
    }

    public function findByUsuarioAndStatus($user = null, $status = null)
    {
        $q = $this->createQueryBuilder("s");

        if (!empty($user)) {
            $q->andWhere('s.usuario = :usuario')
                ->setParameter('usuario', $user);
        }

        if (!empty($status)) {
            $q->andWhere('s.status = :status')
                ->setParameter('status', $status);
        }

        $q->orderBy('s.data_cadastro', 'desc');
        $query = $q->getQuery();
        return $query->getResult();
    }

    public function findByListagem($busca = null, $limite = 16, $ordem = "desc")
    {
        $q = $this->createQueryBuilder('s')
            ->andWhere("s.status = 'P'");

        if (!empty($busca)) {
            $q->andWhere("s.titulo like :busca")
                ->setParameter("busca", "%" . $busca . "%");
        }

        $q->setMaxResults($limite)
            ->orderBy("s.data_cadastro", $ordem);

        $query = $q->getQuery();
        return $query->getResult();

    }

//    /**
//     * @return Servico[] Returns an array of Servico objects
//     */
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
    public function findOneBySomeField($value): ?Servico
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
