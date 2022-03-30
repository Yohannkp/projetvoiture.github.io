<?php

namespace App\Entity;

use App\Repository\InformationsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\MappedSuperclass]
Abstract class Informations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;

    #[ORM\Column(type: 'date', nullable: true)]
    private $creerLe;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $creerPar;

    #[ORM\Column(type: 'date', nullable: true)]
    private $modifierLe;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $modifierPar;

    #[ORM\Column(type: 'boolean')]
    private $statut;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreerLe(): ?\DateTimeInterface
    {
        return $this->creerLe;
    }

    public function setCreerLe(?\DateTimeInterface $creerLe): self
    {
        $this->creerLe = $creerLe;

        return $this;
    }

    public function getCreerPar(): ?string
    {
        return $this->creerPar;
    }

    public function setCreerPar(?string $creerPar): self
    {
        $this->creerPar = $creerPar;

        return $this;
    }

    public function getModifierLe(): ?\DateTimeInterface
    {
        return $this->modifierLe;
    }

    public function setModifierLe(?\DateTimeInterface $modifierLe): self
    {
        $this->modifierLe = $modifierLe;

        return $this;
    }

    public function getModifierPar(): ?string
    {
        return $this->modifierPar;
    }

    public function setModifierPar(?string $modifierPar): self
    {
        $this->modifierPar = $modifierPar;

        return $this;
    }

    public function getStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }
}
