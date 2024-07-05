<?php

// src/Service/ClassementEquipeService.php
namespace App\Service;

use App\Entity\ClassementEquipe;
use App\Entity\Equipe;
use App\Repository\ClassementEquipeRepository;
use Doctrine\ORM\EntityManagerInterface;

class ClassementEquipeService
{
    private $entityManager;
    private $classementEquipeRepository;

    public function __construct(EntityManagerInterface $entityManager, ClassementEquipeRepository $classementEquipeRepository)
    {
        $this->entityManager = $entityManager;
        $this->classementEquipeRepository = $classementEquipeRepository;
    }

    public function updateClassement(): void
    {
        // Suppression des classements existants
        $existingClassements = $this->classementEquipeRepository->findAll();
        foreach ($existingClassements as $classement) {
            $this->entityManager->remove($classement);
        }
        $this->entityManager->flush();

        // Recalculer les classements
        $equipes = $this->entityManager->getRepository(Equipe::class)->findAll();
        usort($equipes, function (Equipe $a, Equipe $b) {
            return $b->getTotalPoints() - $a->getTotalPoints();
        });

        $position = 1;
        foreach ($equipes as $equipe) {
            $classement = new ClassementEquipe();
            $classement->setEquipe($equipe);
            $classement->setPosition($position);
            $this->entityManager->persist($classement);
            $position++;
        }

        $this->entityManager->flush();
    }
}

