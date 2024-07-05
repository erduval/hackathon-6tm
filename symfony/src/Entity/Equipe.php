<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Equipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $dateCreation = null;

    #[ORM\Column(type: 'integer')]
    private int $taille = 0;

    #[ORM\OneToMany(targetEntity: EquipeUtilisateur::class, mappedBy: 'equipe')]
    private Collection $equipeUtilisateurs;

    public function __construct()
    {
        $this->equipeUtilisateurs = new ArrayCollection();
        $this->dateCreation = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;
        return $this;
    }

    public function getTaille(): int
    {
        return $this->taille;
    }

    public function setTaille(int $taille): self
    {
        $this->taille = $taille;
        return $this;
    }

    public function getEquipeUtilisateurs(): Collection
    {
        return $this->equipeUtilisateurs;
    }

    public function addEquipeUtilisateur(EquipeUtilisateur $equipeUtilisateur): self
    {
        if (!$this->equipeUtilisateurs->contains($equipeUtilisateur)) {
            $this->equipeUtilisateurs[] = $equipeUtilisateur;
            $equipeUtilisateur->setEquipe($this);
            $this->taille = count($this->equipeUtilisateurs);
        }

        return $this;
    }

    public function removeEquipeUtilisateur(EquipeUtilisateur $equipeUtilisateur): self
    {
        if ($this->equipeUtilisateurs->removeElement($equipeUtilisateur)) {
            // set the owning side to null (unless already changed)
            if ($equipeUtilisateur->getEquipe() === $this) {
                $equipeUtilisateur->setEquipe(null);
            }
            $this->taille = count($this->equipeUtilisateurs);
        }

        return $this;
    }
}
