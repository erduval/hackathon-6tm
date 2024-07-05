<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Cooptation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Coopteur::class)]
    private ?Coopteur $coopteur = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $dateCooptation = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $statut = null;

    #[ORM\OneToOne(targetEntity: Candidature::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: "candidature_id", referencedColumnName: "id")]
    private ?Candidature $candidature = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateCooptation(): ?\DateTimeInterface
    {
        return $this->dateCooptation;
    }

    public function setDateCooptation(\DateTimeInterface $dateCooptation): self
    {
        $this->dateCooptation = $dateCooptation;
        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;
        return $this;
    }

    public function getCandidature(): ?Candidature
    {
        return $this->candidature;
    }

    public function setCandidature(?Candidature $candidature): self
    {
        $this->candidature = $candidature;
        return $this;
    }
}




