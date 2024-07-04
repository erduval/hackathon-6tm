<?php

namespace App\Controller;

use App\Entity\EquipeUtilisateur;
use App\Entity\Equipe;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EquipeUtilisateurController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/equipe-utilisateurs", name="equipe_utilisateur_index", methods={"GET"})
     */
    public function index(): JsonResponse
    {
        $equipeUtilisateurs = $this->entityManager->getRepository(EquipeUtilisateur::class)->findAll();
        return $this->json($equipeUtilisateurs);
    }

    /**
     * @Route("/equipe-utilisateur", name="equipe_utilisateur_create", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $equipeUtilisateur = new EquipeUtilisateur();
        $equipeUtilisateur->setEquipe($this->entityManager->getRepository(Equipe::class)->find($data['equipe_id']));
        $equipeUtilisateur->setUtilisateur($this->entityManager->getRepository(Utilisateur::class)->find($data['utilisateur_id']));

        $this->entityManager->persist($equipeUtilisateur);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'EquipeUtilisateur created!'], JsonResponse::HTTP_CREATED);
    }

    /**
     * @Route("/equipe-utilisateur/{id}", name="equipe_utilisateur_show", methods={"GET"})
     */
    public function show(int $id): JsonResponse
    {
        $equipeUtilisateur = $this->entityManager->getRepository(EquipeUtilisateur::class)->find($id);

        if (!$equipeUtilisateur) {
            return new JsonResponse(['status' => 'EquipeUtilisateur not found!'], JsonResponse::HTTP_NOT_FOUND);
        }

        return $this->json($equipeUtilisateur);
    }

    /**
     * @Route("/equipe-utilisateur/{id}", name="equipe_utilisateur_update", methods={"PUT"})
     */
    public function update(int $id, Request $request): JsonResponse
    {
        $equipeUtilisateur = $this->entityManager->getRepository(EquipeUtilisateur::class)->find($id);

        if (!$equipeUtilisateur) {
            return new JsonResponse(['status' => 'EquipeUtilisateur not found!'], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        $equipeUtilisateur->setEquipe($this->entityManager->getRepository(Equipe::class)->find($data['equipe_id']));
        $equipeUtilisateur->setUtilisateur($this->entityManager->getRepository(Utilisateur::class)->find($data['utilisateur_id']));

        $this->entityManager->flush();

        return new JsonResponse(['status' => 'EquipeUtilisateur updated!'], JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/equipe-utilisateur/{id}", name="equipe_utilisateur_delete", methods={"DELETE"})
     */
    public function delete(int $id): JsonResponse
    {
        $equipeUtilisateur = $this->entityManager->getRepository(EquipeUtilisateur::class)->find($id);

        if (!$equipeUtilisateur) {
            return new JsonResponse(['status' => 'EquipeUtilisateur not found!'], JsonResponse::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($equipeUtilisateur);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'EquipeUtilisateur deleted!'], JsonResponse::HTTP_OK);
    }
}

