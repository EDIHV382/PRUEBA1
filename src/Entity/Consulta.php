<?php

namespace App\Entity;

use App\Repository\ConsultaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ConsultaRepository::class)]
class Consulta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'consultas')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull]
    private ?Paciente $paciente = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotNull]
    private ?\DateTimeInterface $fechaConsulta = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: "El motivo no puede estar vacío.")]
    private ?string $motivo = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: "El diagnóstico no puede estar vacío.")]
    private ?string $diagnostico = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: "El tratamiento no puede estar vacío.")]
    private ?string $tratamiento = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $observacion = null;

    public function __construct()
    {
        $this->fechaConsulta = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPaciente(): ?Paciente
    {
        return $this->paciente;
    }

    public function setPaciente(?Paciente $paciente): static
    {
        $this->paciente = $paciente;
        return $this;
    }

    public function getFechaConsulta(): ?\DateTimeInterface
    {
        return $this->fechaConsulta;
    }

    public function setFechaConsulta(\DateTimeInterface $fechaConsulta): static
    {
        $this->fechaConsulta = $fechaConsulta;
        return $this;
    }

    public function getMotivo(): ?string
    {
        return $this->motivo;
    }

    public function setMotivo(string $motivo): static
    {
        $this->motivo = $motivo;
        return $this;
    }

    public function getDiagnostico(): ?string
    {
        return $this->diagnostico;
    }

    public function setDiagnostico(string $diagnostico): static
    {
        $this->diagnostico = $diagnostico;
        return $this;
    }

    public function getTratamiento(): ?string
    {
        return $this->tratamiento;
    }

    public function setTratamiento(string $tratamiento): static
    {
        $this->tratamiento = $tratamiento;
        return $this;
    }

    public function getObservacion(): ?string
    {
        return $this->observacion;
    }

    public function setObservacion(?string $observacion): static
    {
        $this->observacion = $observacion;
        return $this;
    }
}