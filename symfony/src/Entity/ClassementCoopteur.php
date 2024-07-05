<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class ClassementCoopteur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private int $position = 0;

    #[ORM\Column(length: 255)]
    private ?string $nomCoopteur = null;

    #[ORM\Column]
    private int $points = 0;

    #[ORM\ManyToOne(targetEntity: Coopteur::class)]
    private ?Coopteur $coopteur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;
        return $this;
    }

    public function getNomCoopteur(): ?string
    {
        return $this->nomCoopteur;
    }

    public function setNomCoopteur(string $nomCoopteur): self
    {
        $this->nomCoopteur = $nomCoopteur;
        return $this;
    }

    public function getPoints(): int
    {
        return $this->points;
    }

    public function setPoints(int $points): self
    {
        $this->points = $points;
        return $this;
    }

    public function getCoopteur(): ?Coopteur
    {
        return $this->coopteur;
    }

    public function setCoopteur(?Coopteur $coopteur): self
    {
        $this->coopteur = $coopteur;
        return $this;
    }
}
