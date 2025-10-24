<?php

namespace App\Repository;

use App\Entity\Gasto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class GastoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gasto::class);
    }

    public function findGastosSinCorteDelDia(\DateTimeInterface $fecha): array
    {
        $inicioDia = (clone $fecha)->setTime(0, 0, 0);
        $finDia = (clone $fecha)->setTime(23, 59, 59);

        return $this->createQueryBuilder('g')
            ->andWhere('g.fecha BETWEEN :inicio AND :fin')
            ->andWhere('g.corteCaja IS NULL')
            ->setParameter('inicio', $inicioDia)
            ->setParameter('fin', $finDia)
            ->orderBy('g.fecha', 'ASC')
            ->getQuery()
            ->getResult();
    }
}