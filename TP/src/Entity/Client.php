<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client extends Personne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $cni;

    #[ORM\Column(type: 'string', length: 255)]
    private $photoIdentite;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Vente::class)]
    private $doctrine;

    public function __construct()
    {
        $this->doctrine = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCni(): ?string
    {
        return $this->cni;
    }

    public function setCni(string $cni): self
    {
        $this->cni = $cni;

        return $this;
    }

    public function getPhotoIdentite(): ?string
    {
        return $this->photoIdentite;
    }

    public function setPhotoIdentite(string $photoIdentite): self
    {
        $this->photoIdentite = $photoIdentite;

        return $this;
    }

    /**
     * @return Collection<int, Vente>
     */
    public function getDoctrine(): Collection
    {
        return $this->doctrine;
    }

    public function addDoctrine(Vente $doctrine): self
    {
        if (!$this->doctrine->contains($doctrine)) {
            $this->doctrine[] = $doctrine;
            $doctrine->setClient($this);
        }

        return $this;
    }

    public function removeDoctrine(Vente $doctrine): self
    {
        if ($this->doctrine->removeElement($doctrine)) {
            // set the owning side to null (unless already changed)
            if ($doctrine->getClient() === $this) {
                $doctrine->setClient(null);
            }
        }

        return $this;
    }
}
