<?php

namespace App\Service;

use App\Entity\ClassementCoopteur;
use App\Entity\Coopteur;
use App\Repository\CoopteurRepository;
use Doctrine\ORM\EntityManagerInterface;

class ClassementCoopteurService
{
    private $entityManager;
    private $coopteurRepository;

    public function __construct(EntityManagerInterface $entityManager, CoopteurRepository $coopteurRepository)
    {
        $this->entityManager = $entityManager;
        $this->coopteurRepository = $coopteurRepository;
    }

    public function updateClassement(): void
    {
        $coopteurs = $this->coopteurRepository->findBy([], ['points' => 'DESC']);

        $position = 1;
        foreach ($coopteurs as $coopteur) {
            $classement = $this->entityManager->getRepository(ClassementCoopteur::class)->findOneBy(['coopteur' => $coopteur]);

            if (!$classement) {
                $classement = new ClassementCoopteur();
                $classement->setCoopteur($coopteur);
            }

            $classement->setPoints($coopteur->getPoints());
            $classement->setPosition($position++);
            $classement->setNomCoopteur($coopteur->getUtilisateur()->getNom());

            $this->entityManager->persist($classement);
        }

        $this->entityManager->flush();
    }
}
