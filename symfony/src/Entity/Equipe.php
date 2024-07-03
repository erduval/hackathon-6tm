<?php

namespace App\Entity;

use App\Repository\EquipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipeRepository::class)]
class Equipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    /**
     * @var Collection<int, Classement>
     */
    #[ORM\OneToMany(targetEntity: Classement::class, mappedBy: 'equipe', orphanRemoval: true)]
    private Collection $classements;

    /**
     * @var Collection<int, EquipeUtilisateur>
     */
    #[ORM\OneToMany(targetEntity: EquipeUtilisateur::class, mappedBy: 'equipe', orphanRemoval: true)]
    private Collection $equipeUtilisateurs;

    public function __construct()
    {
        $this->classements = new ArrayCollection();
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

    /**
     * @return Collection<int, Classement>
     */
    public function getClassements(): Collection
    {
        return $this->classements;
    }

    public function addClassement(Classement $classement): static
    {
        if (!$this->classements->contains($classement)) {
            $this->classements->add($classement);
            $classement->setEquipe($this);
        }

        return $this;
    }

    public function removeClassement(Classement $classement): static
    {
        if ($this->classements->removeElement($classement)) {
            // set the owning side to null (unless already changed)
            if ($classement->getEquipe() === $this) {
                $classement->setEquipe(null);
            }
        }

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
            $equipeUtilisateur->setEquipe($this);
        }

        return $this;
    }

    public function removeEquipeUtilisateur(EquipeUtilisateur $equipeUtilisateur): static
    {
        if ($this->equipeUtilisateurs->removeElement($equipeUtilisateur)) {
            // set the owning side to null (unless already changed)
            if ($equipeUtilisateur->getEquipe() === $this) {
                $equipeUtilisateur->setEquipe(null);
            }
        }

        return $this;
    }
}
