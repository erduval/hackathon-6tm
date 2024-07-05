<?php

namespace App\Controller;

use App\Entity\CooptationOffreEmploi;
use App\Repository\CooptationOffreEmploiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cooptation-offre-emploi')]
class CooptationOffreEmploiController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'cooptation_offre_emploi_index', methods: ['GET'])]
    public function index(CooptationOffreEmploiRepository $cooptationOffreEmploiRepository): JsonResponse
    {
        $cooptationsOffreEmploi = $cooptationOffreEmploiRepository->findAll();
        return $this->json($cooptationsOffreEmploi);
    }

    #[Route('/new', name: 'cooptation_offre_emploi_new', methods: ['POST'])]
    public function new(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $cooptationOffreEmploi = new CooptationOffreEmploi();
        $cooptationOffreEmploi->setCooptation($this->entityManager->getRepository(Cooptation::class)->find($data['cooptation_id']));
        $cooptationOffreEmploi->setOffreEmploi($this->entityManager->getRepository(OffreEmploi::class)->find($data['offre_emploi_id']));

        $this->entityManager->persist($cooptationOffreEmploi);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'CooptationOffreEmploi created!'], JsonResponse::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'cooptation_offre_emploi_show', methods: ['GET'])]
    public function show(CooptationOffreEmploi $cooptationOffreEmploi): JsonResponse
    {
        return $this->json($cooptationOffreEmploi);
    }

    #[Route('/{id}/edit', name: 'cooptation_offre_emploi_edit', methods: ['PUT'])]
    public function edit(Request $request, CooptationOffreEmploi $cooptationOffreEmploi): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $cooptationOffreEmploi->setCooptation($this->entityManager->getRepository(Cooptation::class)->find($data['cooptation_id']));
        $cooptationOffreEmploi->setOffreEmploi($this->entityManager->getRepository(OffreEmploi::class)->find($data['offre_emploi_id']));
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'CooptationOffreEmploi updated!'], JsonResponse::HTTP_OK);
    }

    #[Route('/{id}', name: 'cooptation_offre_emploi_delete', methods: ['DELETE'])]
    public function delete(CooptationOffreEmploi $cooptationOffreEmploi): JsonResponse
    {
        $this->entityManager->remove($cooptationOffreEmploi);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'CooptationOffreEmploi deleted!'], JsonResponse::HTTP_OK);
    }
}
