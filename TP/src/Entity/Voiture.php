<?php

namespace App\Entity;

use App\Repository\VoitureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoitureRepository::class)]
class Voiture extends Informations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $Marque;

    #[ORM\Column(type: 'string', length: 255)]
    private $Model;

    #[ORM\Column(type: 'string', length: 255)]
    private $NumSerie;

    #[ORM\Column(type: 'integer')]
    private $NumeroIdentifiant;

    #[ORM\Column(type: 'date')]
    private $dateAchat;

    #[ORM\Column(type: 'string', length: 255)]
    private $couleur;

    #[ORM\OneToOne(targetEntity: Vente::class, cascade: ['persist', 'remove'])]
    private $doctrine;

    #[ORM\Column(type: 'string', length: 255)]
    private $etat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarque(): ?string
    {
        return $this->Marque;
    }

    public function setMarque(string $Marque): self
    {
        $this->Marque = $Marque;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->Model;
    }

    public function setModel(string $Model): self
    {
        $this->Model = $Model;

        return $this;
    }

    public function getNumSerie(): ?string
    {
        return $this->NumSerie;
    }

    public function setNumSerie(string $NumSerie): self
    {
        $this->NumSerie = $NumSerie;

        return $this;
    }

    public function getNumeroIdentifiant(): ?int
    {
        return $this->NumeroIdentifiant;
    }

    public function setNumeroIdentifiant(int $NumeroIdentifiant): self
    {
        $this->NumeroIdentifiant = $NumeroIdentifiant;

        return $this;
    }

    public function getDateAchat(): ?\DateTimeInterface
    {
        return $this->dateAchat;
    }

    public function setDateAchat(\DateTimeInterface $dateAchat): self
    {
        $this->dateAchat = $dateAchat;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getDoctrine(): ?Vente
    {
        return $this->doctrine;
    }

    public function setDoctrine(?Vente $doctrine): self
    {
        $this->doctrine = $doctrine;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }
    
}
