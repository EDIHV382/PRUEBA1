<?php

namespace App\Repository;

use App\Entity\Pago;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pago>
 */
class PagoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pago::class);
    }

    /**
     * Encuentra todos los pagos de un día específico que aún no tienen un corte de caja asignado.
     * @return Pago[]
     */
    public function findPagosSinCorteDelDiaPorUsuario(\DateTimeInterface $fecha, \App\Entity\User $usuario): array
    {
        $inicioDia = (clone $fecha)->setTime(0, 0, 0);
        $finDia = (clone $fecha)->setTime(23, 59, 59);

        return $this->createQueryBuilder('p')
            ->leftJoin('p.registradoPor', 'u')
            ->andWhere('p.fecha_pago BETWEEN :inicio AND :fin')
            ->andWhere('p.corteCaja IS NULL')
            ->andWhere('p.registradoPor = :usuario')
            ->setParameter('inicio', $inicioDia)
            ->setParameter('fin', $finDia)
            ->setParameter('usuario', $usuario)
            ->orderBy('p.fecha_pago', 'ASC')
            ->getQuery()
            ->getResult();
    }
}