<?php

namespace App\Entity;

use App\Repository\PagoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PagoRepository::class)]
class Pago
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero(message: "El monto no puede ser negativo.")]
    private ?float $monto = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank]
    private ?string $metodo_pago = null; // EFECTIVO, TARJETA, TRANSFERENCIA

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank]
    private ?string $tipo_consulta = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull]
    private ?\DateTime $fecha_pago = null;

    #[ORM\ManyToOne(inversedBy: 'pagos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Paciente $paciente = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true, onDelete: "SET NULL")]
    private ?User  $registradoPor = null;

    #[ORM\ManyToOne(inversedBy: 'pagos')]
    #[ORM\JoinColumn(nullable: true, onDelete: "SET NULL")]
    private ?CorteCaja $corteCaja = null;

    public function __construct()
    {
        $this->fecha_pago = new \DateTime('now', new \DateTimeZone('America/Mexico_City'));
    }

    // ----------------------- GETTERS & SETTERS -----------------------
    public function getId(): ?int { return $this->id; }

    public function getMonto(): ?float { return $this->monto; }
    public function setMonto(float $monto): static { $this->monto = $monto; return $this; }

    public function getMetodoPago(): ?string { return $this->metodo_pago; }
    public function setMetodoPago(string $metodo_pago): static { $this->metodo_pago = $metodo_pago; return $this; }

    public function getTipoConsulta(): ?string { return $this->tipo_consulta; }
    public function setTipoConsulta(string $tipo_consulta): static { $this->tipo_consulta = $tipo_consulta; return $this; }

    public function getFechaPago(): ?\DateTime { return $this->fecha_pago; }
    public function setFechaPago(\DateTime $fecha_pago): static { $this->fecha_pago = $fecha_pago; return $this; }

    public function getPaciente(): ?Paciente { return $this->paciente; }
    public function setPaciente(?Paciente $paciente): static { $this->paciente = $paciente; return $this; }

    public function getRegistradoPor(): ?User  { return $this->registradoPor; }
    public function setRegistradoPor(?User  $user): static { $this->registradoPor = $user; return $this; }

    public function getCorteCaja(): ?CorteCaja { return $this->corteCaja; }
    public function setCorteCaja(?CorteCaja $corteCaja): static { $this->corteCaja = $corteCaja; return $this; }
}
