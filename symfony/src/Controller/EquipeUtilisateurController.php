<?php

namespace App\Controller;

use App\Entity\EquipeUtilisateur;
use App\Repository\EquipeUtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/equipe-utilisateur')]
class EquipeUtilisateurController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'equipe_utilisateur_index', methods: ['GET'])]
    public function index(EquipeUtilisateurRepository $equipeUtilisateurRepository): JsonResponse
    {
        $equipeUtilisateurs = $equipeUtilisateurRepository->findAll();
        return $this->json($equipeUtilisateurs);
    }

    #[Route('/new', name: 'equipe_utilisateur_new', methods: ['POST'])]
    public function new(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $equipeUtilisateur = new EquipeUtilisateur();
        $equipeUtilisateur->setUtilisateur($this->getUser());
        $equipeUtilisateur->setEquipe($this->entityManager->getRepository(Equipe::class)->find($data['equipe_id']));
        $equipeUtilisateur->setRole($data['role']);

        $this->entityManager->persist($equipeUtilisateur);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'EquipeUtilisateur created!'], JsonResponse::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'equipe_utilisateur_show', methods: ['GET'])]
    public function show(EquipeUtilisateur $equipeUtilisateur): JsonResponse
    {
        return $this->json($equipeUtilisateur);
    }

    #[Route('/{id}/edit', name: 'equipe_utilisateur_edit', methods: ['PUT'])]
    public function edit(Request $request, EquipeUtilisateur $equipeUtilisateur): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $equipeUtilisateur->setRole($data['role']);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'EquipeUtilisateur updated!'], JsonResponse::HTTP_OK);
    }

    #[Route('/{id}', name: 'equipe_utilisateur_delete', methods: ['DELETE'])]
    public function delete(EquipeUtilisateur $equipeUtilisateur): JsonResponse
    {
        $this->entityManager->remove($equipeUtilisateur);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'EquipeUtilisateur deleted!'], JsonResponse::HTTP_OK);
    }
}
