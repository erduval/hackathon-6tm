<?php

namespace App\Controller;

use App\Entity\CooptationOffreEmploi;
use App\Entity\Cooptation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CooptationOffreEmploiController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/cooptation-offres", name="cooptation_offre_emploi_index", methods={"GET"})
     */
    public function index(): JsonResponse
    {
        $cooptationOffres = $this->entityManager->getRepository(CooptationOffreEmploi::class)->findAll();
        return $this->json($cooptationOffres);
    }

    /**
     * @Route("/cooptation-offre", name="cooptation_offre_emploi_create", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $cooptationOffre = new CooptationOffreEmploi();
        $cooptationOffre->setCooptation($this->entityManager->getRepository(Cooptation::class)->find($data['cooptation_id']));

        $this->entityManager->persist($cooptationOffre);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Cooptation Offre Emploi created!'], JsonResponse::HTTP_CREATED);
    }

    /**
     * @Route("/cooptation-offre/{id}", name="cooptation_offre_emploi_show", methods={"GET"})
     */
    public function show(int $id): JsonResponse
    {
        $cooptationOffre = $this->entityManager->getRepository(CooptationOffreEmploi::class)->find($id);

        if (!$cooptationOffre) {
            return new JsonResponse(['status' => 'Cooptation Offre Emploi not found!'], JsonResponse::HTTP_NOT_FOUND);
        }

        return $this->json($cooptationOffre);
    }

    /**
     * @Route("/cooptation-offre/{id}", name="cooptation_offre_emploi_update", methods={"PUT"})
     */
    public function update(int $id, Request $request): JsonResponse
    {
        $cooptationOffre = $this->entityManager->getRepository(CooptationOffreEmploi::class)->find($id);

        if (!$cooptationOffre) {
            return new JsonResponse(['status' => 'Cooptation Offre Emploi not found!'], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        $cooptationOffre->setCooptation($this->entityManager->getRepository(Cooptation::class)->find($data['cooptation_id']));

        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Cooptation Offre Emploi updated!'], JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/cooptation-offre/{id}", name="cooptation_offre_emploi_delete", methods={"DELETE"})
     */
    public function delete(int $id): JsonResponse
    {
        $cooptationOffre = $this->entityManager->getRepository(CooptationOffreEmploi::class)->find($id);

        if (!$cooptationOffre) {
            return new JsonResponse(['status' => 'Cooptation Offre Emploi not found!'], JsonResponse::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($cooptationOffre);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Cooptation Offre Emploi deleted!'], JsonResponse::HTTP_OK);
    }
}

