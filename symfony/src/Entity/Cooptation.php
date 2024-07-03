<?php

namespace App\Entity;

use App\Repository\CooptationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CooptationRepository::class)]
class Cooptation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateCooptation = null;

    #[ORM\Column(length: 255)]
    private ?string $statut = null;

    /**
     * @var Collection<int, CooptationOffreEmploi>
     */
    #[ORM\OneToMany(targetEntity: CooptationOffreEmploi::class, mappedBy: 'cooptation', orphanRemoval: true)]
    private Collection $cooptationOffreEmplois;

    public function __construct()
    {
        $this->cooptationOffreEmplois = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCooptation(): ?\DateTimeInterface
    {
        return $this->dateCooptation;
    }

    public function setDateCooptation(\DateTimeInterface $dateCooptation): static
    {
        $this->dateCooptation = $dateCooptation;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * @return Collection<int, CooptationOffreEmploi>
     */
    public function getCooptationOffreEmplois(): Collection
    {
        return $this->cooptationOffreEmplois;
    }

    public function addCooptationOffreEmploi(CooptationOffreEmploi $cooptationOffreEmploi): static
    {
        if (!$this->cooptationOffreEmplois->contains($cooptationOffreEmploi)) {
            $this->cooptationOffreEmplois->add($cooptationOffreEmploi);
            $cooptationOffreEmploi->setCooptation($this);
        }

        return $this;
    }

    public function removeCooptationOffreEmploi(CooptationOffreEmploi $cooptationOffreEmploi): static
    {
        if ($this->cooptationOffreEmplois->removeElement($cooptationOffreEmploi)) {
            // set the owning side to null (unless already changed)
            if ($cooptationOffreEmploi->getCooptation() === $this) {
                $cooptationOffreEmploi->setCooptation(null);
            }
        }

        return $this;
    }
}
