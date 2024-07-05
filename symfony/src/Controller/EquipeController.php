<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Entity\Utilisateur;
use App\Entity\EquipeUtilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/equipe')]
class EquipeController extends AbstractController
{
    #[Route('/', name: 'equipe_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): JsonResponse
    {
        $equipes = $entityManager->getRepository(Equipe::class)->findAll();
        return $this->json($equipes);
    }

    #[Route('/new', name: 'equipe_new', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $equipe = new Equipe();
        $equipe->setNom($data['nom']);

        foreach ($data['membres'] as $membreId) {
            $membre = $entityManager->getRepository(Utilisateur::class)->find($membreId);
            if ($membre) {
                $equipeUtilisateur = new EquipeUtilisateur();
                $equipeUtilisateur->setEquipe($equipe);
                $equipeUtilisateur->setUtilisateur($membre);
                $entityManager->persist($equipeUtilisateur);
                $equipe->addEquipeUtilisateur($equipeUtilisateur);
            }
        }

        $entityManager->persist($equipe);
        $entityManager->flush();

        return new JsonResponse(['status' => 'Equipe created!', 'equipe' => $equipe], JsonResponse::HTTP_CREATED);
    }
}

