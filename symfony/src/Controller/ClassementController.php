<?php

namespace App\Controller;

use App\Entity\Classement;
use App\Entity\Equipe;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ClassementController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/classements", name="classement_index", methods={"GET"})
     */
    public function index(): JsonResponse
    {
        $classements = $this->entityManager->getRepository(Classement::class)->findAll();
        return $this->json($classements);
    }

    /**
     * @Route("/classement", name="classement_create", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $classement = new Classement();
        $classement->setPosition($data['position']);
        $classement->setNomEquipe($data['nomEquipe']);
        $classement->setPoints($data['points']);
        $classement->setEquipe($this->entityManager->getRepository(Equipe::class)->find($data['equipe_id']));

        $this->entityManager->persist($classement);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Classement created!'], JsonResponse::HTTP_CREATED);
    }

    /**
     * @Route("/classement/{id}", name="classement_show", methods={"GET"})
     */
    public function show(int $id): JsonResponse
    {
        $classement = $this->entityManager->getRepository(Classement::class)->find($id);

        if (!$classement) {
            return new JsonResponse(['status' => 'Classement not found!'], JsonResponse::HTTP_NOT_FOUND);
        }

        return $this->json($classement);
    }

    /**
     * @Route("/classement/{id}", name="classement_update", methods={"PUT"})
     */
    public function update(int $id, Request $request): JsonResponse
    {
        $classement = $this->entityManager->getRepository(Classement::class)->find($id);

        if (!$classement) {
            return new JsonResponse(['status' => 'Classement not found!'], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        $classement->setPosition($data['position']);
        $classement->setNomEquipe($data['nomEquipe']);
        $classement->setPoints($data['points']);
        $classement->setEquipe($this->entityManager->getRepository(Equipe::class)->find($data['equipe_id']));

        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Classement updated!'], JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/classement/{id}", name="classement_delete", methods={"DELETE"})
     */
    public function delete(int $id): JsonResponse
    {
        $classement = $this->entityManager->getRepository(Classement::class)->find($id);

        if (!$classement) {
            return new JsonResponse(['status' => 'Classement not found!'], JsonResponse::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($classement);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Classement deleted!'], JsonResponse::HTTP_OK);
    }
}

