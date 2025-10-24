<?php

namespace App\Entity;

use App\Repository\GastoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GastoRepository::class)]
class Gasto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $monto = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $descripcion = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\ManyToOne(inversedBy: 'gastos')]
    private ?CorteCaja $corteCaja = null;

    public function __construct()
    {
        $this->fecha = new \DateTime();
    }

    public function getId(): ?int { return $this->id; }
    public function getMonto(): ?string { return $this->monto; }
    public function setMonto(string $monto): static { $this->monto = $monto; return $this; }
    public function getDescripcion(): ?string { return $this->descripcion; }
    public function setDescripcion(string $descripcion): static { $this->descripcion = $descripcion; return $this; }
    public function getFecha(): ?\DateTimeInterface { return $this->fecha; }
    public function setFecha(\DateTimeInterface $fecha): static { $this->fecha = $fecha; return $this; }
    public function getCorteCaja(): ?CorteCaja { return $this->corteCaja; }
    public function setCorteCaja(?CorteCaja $corteCaja): static { $this->corteCaja = $corteCaja; return $this; }
}