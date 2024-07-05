<?php

namespace App\Service;

use App\Entity\Candidature;
use App\Entity\Cooptation;
use App\Repository\CooptationRepository;
use Doctrine\ORM\EntityManagerInterface;

class CandidatureService
{
    private $entityManager;
    private $cooptationRepository;
    private $classementCoopteurService;
    private $classementEquipeService;

    public function __construct(
        EntityManagerInterface $entityManager,
        CooptationRepository $cooptationRepository,
        ClassementCoopteurService $classementCoopteurService,
        ClassementEquipeService $classementEquipeService
    ) {
        $this->entityManager = $entityManager;
        $this->cooptationRepository = $cooptationRepository;
        $this->classementCoopteurService = $classementCoopteurService;
        $this->classementEquipeService = $classementEquipeService;
    }

    public function updateStatut(Candidature $candidature, string $newStatut): void
    {
        $currentStatut = $candidature->getStatut();
        $candidature->setStatut($newStatut);

        $coopteur = $candidature->getCoopteur();
        if (!$coopteur) {
            throw new \Exception('Coopteur not found for this candidature');
        }

        // Update points based on the new status
        $points = $this->calculatePointsForStatut($newStatut);
        $coopteur->setPoints($coopteur->getPoints() + $points);

        // Mise à jour du statut dans la cooptation
        $cooptation = $this->cooptationRepository->findOneBy(['candidature' => $candidature]);
        if ($cooptation) {
            $cooptation->setStatut($newStatut);
        }

        $this->entityManager->flush();

        // Mettre à jour les classements
        $this->classementCoopteurService->updateClassement();
        $this->classementEquipeService->updateClassement();
    }

    private function calculatePointsForStatut(string $statut): int
    {
        $points = [
            'go' => 1,
            'no go' => 0,
            'Precal Tele' => 1,
            'Entretien RH' => 2,
            'Entretien Manager' => 3,
            'Recruté' => 5,
        ];

        return $points[$statut] ?? 0;
    }
}





