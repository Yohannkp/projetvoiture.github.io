<?php

namespace App\Entity;

use App\Repository\EtatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtatRepository::class)]
class Etat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255,nullable: true)]
    private $Statut;

    #[ORM\OneToMany(mappedBy: 'etat', targetEntity: Voiture::class)]
    private $relation;

    public function __construct()
    {
        $this->relation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatut(): ?string
    {
        return $this->Statut;
    }

    public function setStatut(string $Statut): self
    {
        $this->Statut = $Statut;

        return $this;
    }

    /**
     * @return Collection<int, Voiture>
     */
    public function getRelation(): Collection
    {
        return $this->relation;
    }

    public function addRelation(Voiture $relation): self
    {
        if (!$this->relation->contains($relation)) {
            $this->relation[] = $relation;
            $relation->setEtat($this);
        }

        return $this;
    }

    public function removeRelation(Voiture $relation): self
    {
        if ($this->relation->removeElement($relation)) {
            // set the owning side to null (unless already changed)
            if ($relation->getEtat() === $this) {
                $relation->setEtat(null);
            }
        }

        return $this;
    }
}
