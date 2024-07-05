<?php
namespace App\Service;

use App\Entity\Cooptation;
use Doctrine\ORM\EntityManagerInterface;

class CooptationService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function updateStatut(Cooptation $cooptation, string $newStatut): void
    {
        $cooptation->setStatut($newStatut);
        $this->entityManager->flush();
    }
}
