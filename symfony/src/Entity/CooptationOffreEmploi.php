<?php

namespace App\Entity;

use App\Repository\CooptationOffreEmploiRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CooptationOffreEmploiRepository::class)]
class CooptationOffreEmploi
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'cooptationOffreEmplois')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cooptation $cooptation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCooptation(): ?Cooptation
    {
        return $this->cooptation;
    }

    public function setCooptation(?Cooptation $cooptation): static
    {
        $this->cooptation = $cooptation;

        return $this;
    }
}
