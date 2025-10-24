<?php

namespace App\Entity;

use App\Repository\CorteCajaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CorteCajaRepository::class)]
class CorteCaja
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $efectivo_inicial = '0.00';

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $efectivo_final = '0.00';

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $total_efectivo = '0.00';

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $total_terminal = '0.00';

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $total_transferencia = '0.00';
    
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $total_gastos = '0.00';

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $total_general = '0.00';

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $observacion = null;

    #[ORM\ManyToOne(inversedBy: 'corteCajas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $usuario = null;

    #[ORM\OneToMany(mappedBy: 'corteCaja', targetEntity: Pago::class, cascade: ['persist'])]
    private Collection $pagos;

    #[ORM\OneToMany(mappedBy: 'corteCaja', targetEntity: Gasto::class, cascade: ['persist'])]
    private Collection $gastos;

    public function __construct()
    {
        $this->pagos = new ArrayCollection();
        $this->gastos = new ArrayCollection();
        $this->fecha = new \DateTime('now', new \DateTimeZone('America/Mexico_City'));
    }
    
    public function calcularTotales(): static
    {
        $efectivo = 0.0;
        $tarjeta = 0.0;
        $transferencia = 0.0;
        foreach ($this->pagos as $pago) {
            switch (strtoupper($pago->getMetodoPago())) {
                case 'EFECTIVO': $efectivo += (float)$pago->getMonto(); break;
                case 'TARJETA': $tarjeta += (float)$pago->getMonto(); break;
                case 'TRANSFERENCIA': $transferencia += (float)$pago->getMonto(); break;
            }
        }
        $this->total_efectivo = (string)$efectivo;
        $this->total_terminal = (string)$tarjeta;
        $this->total_transferencia = (string)$transferencia;

        $totalGastos = 0.0;
        foreach ($this->gastos as $gasto) {
            $totalGastos += (float)$gasto->getMonto();
        }
        $this->total_gastos = (string)$totalGastos;

        $this->total_general = $efectivo + $tarjeta + $transferencia;

        return $this;
    }

    public function calcularTotalesParciales(iterable $pagos, iterable $gastos): static
    {
        $efectivo = 0.0;
        $tarjeta = 0.0;
        $transferencia = 0.0;
        foreach ($pagos as $pago) {
            switch (strtoupper($pago->getMetodoPago())) {
                case 'EFECTIVO': $efectivo += (float)$pago->getMonto(); break;
                case 'TARJETA': $tarjeta += (float)$pago->getMonto(); break;
                case 'TRANSFERENCIA': $transferencia += (float)$pago->getMonto(); break;
            }
        }
        $this->total_efectivo = (string)$efectivo;
        $this->total_terminal = (string)$tarjeta;
        $this->total_transferencia = (string)$transferencia;

        $totalGastos = 0.0;
        foreach ($gastos as $gasto) {
            $totalGastos += (float)$gasto->getMonto();
        }
        $this->total_gastos = (string)$totalGastos;
        
        $this->total_general = $efectivo + $tarjeta + $transferencia;

        return $this;
    }
    
    public function getId(): ?int { return $this->id; }
    public function getFecha(): ?\DateTimeInterface { return $this->fecha; }
    public function setFecha(\DateTimeInterface $fecha): static { $this->fecha = $fecha; return $this; }
    public function getEfectivoInicial(): ?string { return $this->efectivo_inicial; }
    public function setEfectivoInicial(string $efectivo_inicial): static { $this->efectivo_inicial = $efectivo_inicial; return $this; }
    public function getEfectivoFinal(): ?string { return $this->efectivo_final; }
    public function setEfectivoFinal(string $efectivo_final): static { $this->efectivo_final = $efectivo_final; return $this; }
    public function getTotalEfectivo(): ?string { return $this->total_efectivo; }
    public function setTotalEfectivo(string $total_efectivo): static { $this->total_efectivo = $total_efectivo; return $this; }
    public function getTotalTerminal(): ?string { return $this->total_terminal; }
    public function setTotalTerminal(string $total_terminal): static { $this->total_terminal = $total_terminal; return $this; }
    public function getTotalTransferencia(): ?string { return $this->total_transferencia; }
    public function setTotalTransferencia(string $total_transferencia): static { $this->total_transferencia = $total_transferencia; return $this; }
    public function getTotalGastos(): ?string { return $this->total_gastos; }
    public function setTotalGastos(string $total_gastos): static { $this->total_gastos = $total_gastos; return $this; }
    public function getTotalGeneral(): ?string { return $this->total_general; }
    public function setTotalGeneral(string $total_general): static { $this->total_general = $total_general; return $this; }
    public function getObservacion(): ?string { return $this->observacion; }
    public function setObservacion(?string $observacion): static { $this->observacion = $observacion; return $this; }
    public function getUsuario(): ?User { return $this->usuario; }
    public function setUsuario(?User $usuario): static { $this->usuario = $usuario; return $this; }

    /** @return Collection<int, Pago> */
    public function getPagos(): Collection { return $this->pagos; }
    public function addPago(Pago $pago): static {
        if (!$this->pagos->contains($pago)) {
            $this->pagos->add($pago);
            $pago->setCorteCaja($this);
        }
        return $this;
    }
    public function removePago(Pago $pago): static {
        if ($this->pagos->removeElement($pago) && $pago->getCorteCaja() === $this) {
            $pago->setCorteCaja(null);
        }
        return $this;
    }

    /** @return Collection<int, Gasto> */
    public function getGastos(): Collection { return $this->gastos; }
    public function addGasto(Gasto $gasto): static {
        if (!$this->gastos->contains($gasto)) {
            $this->gastos->add($gasto);
            $gasto->setCorteCaja($this);
        }
        return $this;
    }
    public function removeGasto(Gasto $gasto): static {
        if ($this->gastos->removeElement($gasto) && $gasto->getCorteCaja() === $this) {
            $gasto->setCorteCaja(null);
        }
        return $this;
    }
}