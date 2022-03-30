<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;


#[ORM\Entity(repositoryClass: PersonneRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[UniqueEntity(fields: ['NomUtilisateur'], message: 'There is already an account with this username')]
class Personne implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    
    #[ORM\Column(type: 'integer')]
    protected $id;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string', length: 255)]
    protected $Nom;

    #[ORM\Column(type: 'string', length: 255)]
    protected $Prenom;

    #[ORM\Column(type: 'string', length: 255)]
    protected $Telephone;

    #[ORM\Column(type: 'string', length: 255)]
    protected $NomUtilisateur;

    #[ORM\Column(type: 'string', length: 255)]
    protected $MotDePass;

    
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


    
    #[ORM\Column(type: 'date')]
    protected $Age;

    #[ORM\ManyToOne(targetEntity: Role::class, inversedBy: 'relation')]
    private $role;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): self
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->Telephone;
    }

    public function setTelephone(string $Telephone): self
    {
        $this->Telephone = $Telephone;

        return $this;
    }

    public function getNomUtilisateur(): ?string
    {
        return $this->NomUtilisateur;
    }

    public function setNomUtilisateur(string $NomUtilisateur): self
    {
        $this->NomUtilisateur = $NomUtilisateur;

        return $this;
    }

    public function getMotDePass(): ?string
    {
        return $this->MotDePass;
    }

    public function setMotDePass(string $MotDePass): self
    {
        $this->MotDePass = $MotDePass;

        return $this;
    }

    public function getAge(): ?\DateTimeInterface
    {
        return $this->Age;
    }

    public function setAge(\DateTimeInterface $Age): self
    {
        $this->Age = $Age;

        return $this;
    }
/*    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }
/*
    
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    
    public function getPassword(): string
    {
        return $this->MotDePass;
    }

    public function setPassword(string $password): self
    {
        $this->MotDePass = $password;

        return $this;
    }

    
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
    */
    
   

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $roleuser): self
    {
        $this->role = $roleuser;

        return $this;
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
    
    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->NomUtilisateur;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->MotDePass;
    }

    public function setPassword(string $password): self
    {
        $this->MotDePass = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

}

