<?php

namespace App\Controller;

use App\Entity\OffreEmploi;
use App\Entity\Notification;
use App\Repository\OffreEmploiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/offre_emploi')]
class OffreEmploiController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'offre_emploi_index', methods: ['GET'])]
    public function index(OffreEmploiRepository $offreEmploiRepository): JsonResponse
    {
        $offres = $offreEmploiRepository->findAll();
        return $this->json($offres);
    }

    #[Route('/new', name: 'offre_emploi_new', methods: ['POST'])]
    public function new(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $notification = $this->entityManager->getRepository(Notification::class)->find($data['notification_id']);
        if (!$notification) {
            return new JsonResponse(['status' => 'Notification not found!'], JsonResponse::HTTP_NOT_FOUND);
        }

        $offre = new OffreEmploi();
        $offre->setTitre($data['titre']);
        $offre->setDescription($data['description']);
        $offre->setDatePublication(new \DateTime($data['datePublication']));
        $offre->setNotification($notification);

        $this->entityManager->persist($offre);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'OffreEmploi created!'], JsonResponse::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'offre_emploi_show', methods: ['GET'])]
    public function show(OffreEmploi $offreEmploi): JsonResponse
    {
        return $this->json($offreEmploi);
    }

    #[Route('/{id}/edit', name: 'offre_emploi_edit', methods: ['PUT'])]
    public function edit(Request $request, OffreEmploi $offreEmploi): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $offreEmploi->setTitre($data['titre']);
        $offreEmploi->setDescription($data['description']);
        $offreEmploi->setDatePublication(new \DateTime($data['datePublication']));
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'OffreEmploi updated!'], JsonResponse::HTTP_OK);
    }

    #[Route('/{id}', name: 'offre_emploi_delete', methods: ['DELETE'])]
    public function delete(OffreEmploi $offreEmploi): JsonResponse
    {
        $this->entityManager->remove($offreEmploi);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'OffreEmploi deleted!'], JsonResponse::HTTP_OK);
    }
}
