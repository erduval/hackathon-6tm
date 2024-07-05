<?php

namespace App\Controller;

use App\Repository\ClassementCoopteurRepository;
use App\Service\ClassementCoopteurService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/classement-coopteur')]
class ClassementCoopteurController extends AbstractController
{
    private $classementCoopteurService;

    public function __construct(ClassementCoopteurService $classementCoopteurService)
    {
        $this->classementCoopteurService = $classementCoopteurService;
    }

    #[Route('/', name: 'classement_coopteur_index', methods: ['GET'])]
    public function index(ClassementCoopteurRepository $classementCoopteurRepository): Response
    {
        $classements = $classementCoopteurRepository->findAll();
        return $this->json($classements);
    }

    #[Route('/update', name: 'classement_coopteur_update', methods: ['POST'])]
    public function updateClassement(): Response
    {
        $this->classementCoopteurService->updateClassement();
        return $this->json(['message' => 'Classement Coopteur updated successfully']);
    }
}
