<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $motDePasse = null;

    #[ORM\OneToOne(mappedBy: 'utilisateur', cascade: ['persist', 'remove'])]
    private ?RH $rH = null;

    #[ORM\OneToOne(mappedBy: 'utilisateur', cascade: ['persist', 'remove'])]
    private ?Coopteur $coopteur = null;

    /**
     * @var Collection<int, EquipeUtilisateur>
     */
    #[ORM\OneToMany(targetEntity: EquipeUtilisateur::class, mappedBy: 'utilisateur', orphanRemoval: true)]
    private Collection $equipeUtilisateurs;

    public function __construct()
    {
        $this->equipeUtilisateurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getMotDePasse(): ?string
    {
        return $this->motDePasse;
    }

    public function setMotDePasse(string $motDePasse): static
    {
        $this->motDePasse = $motDePasse;
        return $this;
    }

    public function getRH(): ?RH
    {
        return $this->rH;
    }

    public function setRH(RH $rH): static
    {
        // set the owning side of the relation if necessary
        if ($rH->getUtilisateur() !== $this) {
            $rH->setUtilisateur($this);
        }

        $this->rH = $rH;
        return $this;
    }

    public function getCoopteur(): ?Coopteur
    {
        return $this->coopteur;
    }

    public function setCoopteur(Coopteur $coopteur): static
    {
        // set the owning side of the relation if necessary
        if ($coopteur->getUtilisateur() !== $this) {
            $coopteur->setUtilisateur($this);
        }

        $this->coopteur = $coopteur;
        return $this;
    }

    /**
     * @return Collection<int, EquipeUtilisateur>
     */
    public function getEquipeUtilisateurs(): Collection
    {
        return $this->equipeUtilisateurs;
    }

    public function addEquipeUtilisateur(EquipeUtilisateur $equipeUtilisateur): static
    {
        if (!$this->equipeUtilisateurs->contains($equipeUtilisateur)) {
            $this->equipeUtilisateurs->add($equipeUtilisateur);
            $equipeUtilisateur->setUtilisateur($this);
        }

        return $this;
    }

    public function removeEquipeUtilisateur(EquipeUtilisateur $equipeUtilisateur): static
    {
        if ($this->equipeUtilisateurs->removeElement($equipeUtilisateur)) {
            // set the owning side to null (unless already changed)
            if ($equipeUtilisateur->getUtilisateur() === $this) {
                $equipeUtilisateur->setUtilisateur(null);
            }
        }

        return $this;
    }
}
