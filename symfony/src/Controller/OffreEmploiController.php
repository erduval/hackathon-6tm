<?php

namespace App\Controller;

use App\Entity\OffreEmploi;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OffreEmploiController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/offres", name="offre_emploi_index", methods={"GET"})
     */
    public function index(): JsonResponse
    {
        $offres = $this->entityManager->getRepository(OffreEmploi::class)->findAll();
        return $this->json($offres);
    }

    /**
     * @Route("/offre", name="offre_emploi_create", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $offre = new OffreEmploi();
        $offre->setTitre($data['titre']);
        $offre->setDescription($data['description']);
        $offre->setDatePublication(new \DateTime($data['datePublication']));

        $this->entityManager->persist($offre);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Offre d\'emploi created!'], JsonResponse::HTTP_CREATED);
    }

    /**
     * @Route("/offre/{id}", name="offre_emploi_show", methods={"GET"})
     */
    public function show(int $id): JsonResponse
    {
        $offre = $this->entityManager->getRepository(OffreEmploi::class)->find($id);

        if (!$offre) {
            return new JsonResponse(['status' => 'Offre d\'emploi not found!'], JsonResponse::HTTP_NOT_FOUND);
        }

        return $this->json($offre);
    }

    /**
     * @Route("/offre/{id}", name="offre_emploi_update", methods={"PUT"})
     */
    public function update(int $id, Request $request): JsonResponse
    {
        $offre = $this->entityManager->getRepository(OffreEmploi::class)->find($id);

        if (!$offre) {
            return new JsonResponse(['status' => 'Offre d\'emploi not found!'], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        $offre->setTitre($data['titre']);
        $offre->setDescription($data['description']);
        $offre->setDatePublication(new \DateTime($data['datePublication']));

        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Offre d\'emploi updated!'], JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/offre/{id}", name="offre_emploi_delete", methods={"DELETE"})
     */
    public function delete(int $id): JsonResponse
    {
        $offre = $this->entityManager->getRepository(OffreEmploi::class)->find($id);

        if (!$offre) {
            return new JsonResponse(['status' => 'Offre d\'emploi not found!'], JsonResponse::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($offre);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Offre d\'emploi deleted!'], JsonResponse::HTTP_OK);
    }
}

