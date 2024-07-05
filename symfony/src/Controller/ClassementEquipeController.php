<?php

namespace App\Controller;

use App\Repository\ClassementEquipeRepository;
use App\Service\ClassementEquipeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/classement-equipe')]
class ClassementEquipeController extends AbstractController
{
    private $classementEquipeService;

    public function __construct(ClassementEquipeService $classementEquipeService)
    {
        $this->classementEquipeService = $classementEquipeService;
    }

    #[Route('/', name: 'classement_equipe_index', methods: ['GET'])]
    public function index(ClassementEquipeRepository $classementEquipeRepository): Response
    {
        $classements = $classementEquipeRepository->findAll();
        return $this->json($classements);
    }

    #[Route('/update', name: 'classement_equipe_update', methods: ['POST'])]
    public function updateClassement(): Response
    {
        $this->classementEquipeService->updateClassement();
        return $this->json(['message' => 'Classement Equipe updated successfully']);
    }
}
