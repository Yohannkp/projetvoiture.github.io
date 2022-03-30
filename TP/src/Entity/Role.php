<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoleRepository::class)]
class Role
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $Roleuser;

    #[ORM\OneToMany(mappedBy: 'role', targetEntity: Personne::class)]
    private $role;

    #[ORM\OneToMany(mappedBy: 'roleuser', targetEntity: Personne::class)]
    private $relation;

    public function __construct()
    {
        $this->role = new ArrayCollection();
        $this->relation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoleuser(): ?string
    {
        return $this->Roleuser;
    }

    public function setRoleuser(string $Roleuser): self
    {
        $this->Roleuser = $Roleuser;

        return $this;
    }

    /**
     * @return Collection<int, Personne>
     */
    public function getRole(): Collection
    {
        return $this->role;
    }

    public function addRole(Personne $role): self
    {
        if (!$this->role->contains($role)) {
            $this->role[] = $role;
            $role->setRole($this);
        }

        return $this;
    }

    public function removeRole(Personne $role): self
    {
        if ($this->role->removeElement($role)) {
            // set the owning side to null (unless already changed)
            if ($role->getRole() === $this) {
                $role->setRole(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Personne>
     */
    public function getRelation(): Collection
    {
        return $this->relation;
    }

    public function addRelation(Personne $relation): self
    {
        if (!$this->relation->contains($relation)) {
            $this->relation[] = $relation;
            $relation->setRole($this);
        }

        return $this;
    }

    public function removeRelation(Personne $relation): self
    {
        if ($this->relation->removeElement($relation)) {
            // set the owning side to null (unless already changed)
            if ($relation->getRole() === $this) {
                $relation->setRole(null);
            }
        }

        return $this;
    }
}
