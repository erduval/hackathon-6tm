<?php

namespace App\Controller;


use App\Entity\Cooptation;
use App\Repository\CooptationRepository;
use App\Service\CooptationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cooptation')]
class CooptationController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'cooptation_index', methods: ['GET'])]
    public function index(CooptationRepository $cooptationRepository): JsonResponse
    {
        $cooptations = $cooptationRepository->findAll();
        return $this->json($cooptations);
    }

    #[Route('/new', name: 'cooptation_new', methods: ['POST'])]
    public function new(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $cooptation = new Cooptation();
        $cooptation->setNom($data['nom']);
        $cooptation->setPrenom($data['prenom']);
        $cooptation->setEmail($data['email']);
        $cooptation->setNumeroTelephone($data['numeroTelephone']);
        $cooptation->setDomaineRecrutement($data['domaineRecrutement']);
        $cooptation->setCv($data['cv']);
        $cooptation->setLienLinkedin($data['lienLinkedin']);
        $cooptation->setStatut($data['statut']);
        $cooptation->setCreatedAt(new \DateTime());

        $this->entityManager->persist($cooptation);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Cooptation created!'], JsonResponse::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'cooptation_show', methods: ['GET'])]
    public function show(Cooptation $cooptation): JsonResponse
    {
        return $this->json($cooptation);
    }

    #[Route('/{id}/edit', name: 'cooptation_edit', methods: ['PUT'])]
    public function edit(Request $request, Cooptation $cooptation): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $cooptation->setNom($data['nom']);
        $cooptation->setPrenom($data['prenom']);
        $cooptation->setEmail($data['email']);
        $cooptation->setNumeroTelephone($data['numeroTelephone']);
        $cooptation->setDomaineRecrutement($data['domaineRecrutement']);
        $cooptation->setCv($data['cv']);
        $cooptation->setLienLinkedin($data['lienLinkedin']);
        $cooptation->setStatut($data['statut']);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Cooptation updated!'], JsonResponse::HTTP_OK);
    }

    #[Route('/{id}', name: 'cooptation_delete', methods: ['DELETE'])]
    public function delete(Cooptation $cooptation): JsonResponse
    {
        $this->entityManager->remove($cooptation);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Cooptation deleted!'], JsonResponse::HTTP_OK);
    }

    #[Route('/{id}/statut', name: 'cooptation_update_statut', methods: ['PUT'])]
    public function updateStatut(int $id, Request $request): JsonResponse
    {
        $cooptation = $this->entityManager->getRepository(Cooptation::class)->find($id);

        if (!$cooptation) {
            return new JsonResponse(['status' => 'Cooptation not found!'], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        $newStatut = $data['statut'];

        $this->cooptationService->updateStatut($cooptation, $newStatut);

        return new JsonResponse(['status' => 'Cooptation statut updated!'], JsonResponse::HTTP_OK);
    }
}
