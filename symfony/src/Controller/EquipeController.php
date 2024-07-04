<?php

namespace App\Controller;

use App\Entity\Equipe;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EquipeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/equipes", name="equipe_index", methods={"GET"})
     */
    public function index(): JsonResponse
    {
        $equipes = $this->entityManager->getRepository(Equipe::class)->findAll();
        return $this->json($equipes);
    }

    /**
     * @Route("/equipe", name="equipe_create", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $equipe = new Equipe();
        $equipe->setNom($data['nom']);

        $this->entityManager->persist($equipe);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Equipe created!'], JsonResponse::HTTP_CREATED);
    }

    /**
     * @Route("/equipe/{id}", name="equipe_show", methods={"GET"})
     */
    public function show(int $id): JsonResponse
    {
        $equipe = $this->entityManager->getRepository(Equipe::class)->find($id);

        if (!$equipe) {
            return new JsonResponse(['status' => 'Equipe not found!'], JsonResponse::HTTP_NOT_FOUND);
        }

        return $this->json($equipe);
    }

    /**
     * @Route("/equipe/{id}", name="equipe_update", methods={"PUT"})
     */
    public function update(int $id, Request $request): JsonResponse
    {
        $equipe = $this->entityManager->getRepository(Equipe::class)->find($id);

        if (!$equipe) {
            return new JsonResponse(['status' => 'Equipe not found!'], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        $equipe->setNom($data['nom']);

        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Equipe updated!'], JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/equipe/{id}", name="equipe_delete", methods={"DELETE"})
     */
    public function delete(int $id): JsonResponse
    {
        $equipe = $this->entityManager->getRepository(Equipe::class)->find($id);

        if (!$equipe) {
            return new JsonResponse(['status' => 'Equipe not found!'], JsonResponse::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($equipe);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Equipe deleted!'], JsonResponse::HTTP_OK);
    }
}


