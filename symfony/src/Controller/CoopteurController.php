<?php

namespace App\Controller;

use App\Entity\Coopteur;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CoopteurController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/coopteurs", name="coopteur_index", methods={"GET"})
     */
    public function index(): JsonResponse
    {
        $coopteurs = $this->entityManager->getRepository(Coopteur::class)->findAll();
        return $this->json($coopteurs);
    }

    /**
     * @Route("/coopteur", name="coopteur_create", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $coopteur = new Coopteur();
        $coopteur->setPoints($data['points']);
        $coopteur->setUtilisateur($this->entityManager->getRepository(Utilisateur::class)->find($data['utilisateur_id']));

        $this->entityManager->persist($coopteur);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Coopteur created!'], JsonResponse::HTTP_CREATED);
    }

    /**
     * @Route("/coopteur/{id}", name="coopteur_show", methods={"GET"})
     */
    public function show(int $id): JsonResponse
    {
        $coopteur = $this->entityManager->getRepository(Coopteur::class)->find($id);

        if (!$coopteur) {
            return new JsonResponse(['status' => 'Coopteur not found!'], JsonResponse::HTTP_NOT_FOUND);
        }

        return $this->json($coopteur);
    }

    /**
     * @Route("/coopteur/{id}", name="coopteur_update", methods={"PUT"})
     */
    public function update(int $id, Request $request): JsonResponse
    {
        $coopteur = $this->entityManager->getRepository(Coopteur::class)->find($id);

        if (!$coopteur) {
            return new JsonResponse(['status' => 'Coopteur not found!'], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        $coopteur->setPoints($data['points']);
        $coopteur->setUtilisateur($this->entityManager->getRepository(Utilisateur::class)->find($data['utilisateur_id']));

        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Coopteur updated!'], JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/coopteur/{id}", name="coopteur_delete", methods={"DELETE"})
     */
    public function delete(int $id): JsonResponse
    {
        $coopteur = $this->entityManager->getRepository(Coopteur::class)->find($id);

        if (!$coopteur) {
            return new JsonResponse(['status' => 'Coopteur not found!'], JsonResponse::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($coopteur);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Coopteur deleted!'], JsonResponse::HTTP_OK);
    }
}

