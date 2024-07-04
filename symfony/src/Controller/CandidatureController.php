<?php

namespace App\Controller;

use App\Entity\Candidature;
use App\Entity\Coopteur;
use App\Entity\OffreEmploi;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CandidatureController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager; // Correction de l'erreur de syntaxe
    }

    /**
     * @Route("/candidatures", name="candidature_index", methods={"GET"})
     */
    public function index(): JsonResponse
    {
        $candidatures = $this->entityManager->getRepository(Candidature::class)->findAll();
        return $this->json($candidatures);
    }

    /**
     * @Route("/candidature", name="candidature_create", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $candidature = new Candidature();
        $candidature->setCv($data['cv']);
        $candidature->setLien($data['lien']);
        $candidature->setNom($data['nom']);
        $candidature->setPrenom($data['prenom']);
        $candidature->setCoopteur($this->entityManager->getRepository(Coopteur::class)->find($data['coopteur_id']));
        $candidature->setOffreEmploi($this->entityManager->getRepository(OffreEmploi::class)->find($data['offreEmploi_id']));

        $this->entityManager->persist($candidature);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Candidature created!'], JsonResponse::HTTP_CREATED);
    }

    /**
     * @Route("/candidature/{id}", name="candidature_show", methods={"GET"})
     */
    public function show(int $id): JsonResponse
    {
        $candidature = $this->entityManager->getRepository(Candidature::class)->find($id);

        if (!$candidature) {
            return new JsonResponse(['status' => 'Candidature not found!'], JsonResponse::HTTP_NOT_FOUND);
        }

        return $this->json($candidature);
    }

    /**
     * @Route("/candidature/{id}", name="candidature_update", methods={"PUT"})
     */
    public function update(int $id, Request $request): JsonResponse
    {
        $candidature = $this->entityManager->getRepository(Candidature::class)->find($id);

        if (!$candidature) {
            return new JsonResponse(['status' => 'Candidature not found!'], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        $candidature->setCv($data['cv']);
        $candidature->setLien($data['lien']);
        $candidature->setNom($data['nom']);
        $candidature->setPrenom($data['prenom']);
        $candidature->setCoopteur($this->entityManager->getRepository(Coopteur::class)->find($data['coopteur_id']));
        $candidature->setOffreEmploi($this->entityManager->getRepository(OffreEmploi::class)->find($data['offreEmploi_id']));

        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Candidature updated!'], JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/candidature/{id}", name="candidature_delete", methods={"DELETE"})
     */
    public function delete(int $id): JsonResponse
    {
        $candidature = $this->entityManager->getRepository(Candidature::class)->find($id);

        if (!$candidature) {
            return new JsonResponse(['status' => 'Candidature not found!'], JsonResponse::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($candidature);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Candidature deleted!'], JsonResponse::HTTP_OK);
    }
}



