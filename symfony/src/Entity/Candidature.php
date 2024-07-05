<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Candidature
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Coopteur::class)]
    private ?Coopteur $coopteur = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $statut = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: 'blob')]
    private $cv = null;

    #[ORM\Column(length: 255)]
    private ?string $lien = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $telephone = null;

    #[ORM\Column(length: 255)]
    private ?string $domaine = null;

    #[ORM\ManyToOne(targetEntity: OffreEmploi::class)]
    private ?OffreEmploi $offreEmploi = null;

    #[ORM\OneToOne(targetEntity: Cooptation::class, mappedBy: 'candidature')]
    private ?Cooptation $cooptation = null;

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

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getCv()
    {
        return $this->cv;
    }

    public function setCv($cv): self
    {
        $this->cv = $cv;
        return $this;
    }

    public function getLien(): ?string
    {
        return $this->lien;
    }

    public function setLien(string $lien): self
    {
        $this->lien = $lien;
        return $this;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;
        return $this;
    }

    public function getDomaine(): ?string
    {
        return $this->domaine;
    }

    public function setDomaine(string $domaine): self
    {
        $this->domaine = $domaine;
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

    public function getCooptation(): ?Cooptation
    {
        return $this->cooptation;
    }

    public function setCooptation(?Cooptation $cooptation): self
    {
        $this->cooptation = $cooptation;
        return $this;
    }
}


