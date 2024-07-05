<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class CooptationOffreEmploi
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Cooptation::class)]
    private ?Cooptation $cooptation = null;

    #[ORM\ManyToOne(targetEntity: OffreEmploi::class)]
    private ?OffreEmploi $offreEmploi = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCooptation(): ?Cooptation
    {
        return $this->cooptation;
    }

    public function setCooptation(?Cooptation $cooptation): self
    {
        $this->cooptation = $cooptation;
        return $this;
    }

    public function getOffreEmploi(): ?OffreEmploi
    {
        return $this->offreEmploi;
    }

    public function setOffreEmploi(?OffreEmploi $offreEmploi): self
    {
        $this->offreEmploi = $offreEmploi;
        return $this;
    }
}
