<?php

namespace App\Controller;

use App\Entity\Cooptation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CooptationController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/cooptations", name="cooptation_index", methods={"GET"})
     */
    public function index(): JsonResponse
    {
        $cooptations = $this->entityManager->getRepository(Cooptation::class)->findAll();
        return $this->json($cooptations);
    }

    /**
     * @Route("/cooptation", name="cooptation_create", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $cooptation = new Cooptation();
        $cooptation->setDateCooptation(new \DateTime($data['dateCooptation']));
        $cooptation->setStatut($data['statut']);

        $this->entityManager->persist($cooptation);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Cooptation created!'], JsonResponse::HTTP_CREATED);
    }

    /**
     * @Route("/cooptation/{id}", name="cooptation_show", methods={"GET"})
     */
    public function show(int $id): JsonResponse
    {
        $cooptation = $this->entityManager->getRepository(Cooptation::class)->find($id);

        if (!$cooptation) {
            return new JsonResponse(['status' => 'Cooptation not found!'], JsonResponse::HTTP_NOT_FOUND);
        }

        return $this->json($cooptation);
    }

    /**
     * @Route("/cooptation/{id}", name="cooptation_update", methods={"PUT"})
     */
    public function update(int $id, Request $request): JsonResponse
    {
        $cooptation = $this->entityManager->getRepository(Cooptation::class)->find($id);

        if (!$cooptation) {
            return new JsonResponse(['status' => 'Cooptation not found!'], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        $cooptation->setDateCooptation(new \DateTime($data['dateCooptation']));
        $cooptation->setStatut($data['statut']);

        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Cooptation updated!'], JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/cooptation/{id}", name="cooptation_delete", methods={"DELETE"})
     */
    public function delete(int $id): JsonResponse
    {
        $cooptation = $this->entityManager->getRepository(Cooptation::class)->find($id);

        if (!$cooptation) {
            return new JsonResponse(['status' => 'Cooptation not found!'], JsonResponse::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($cooptation);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Cooptation deleted!'], JsonResponse::HTTP_OK);
    }
}
