<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UtilisateurController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/utilisateurs", name="utilisateur_index", methods={"GET"})
     */
    public function index(): JsonResponse
    {
        $utilisateurs = $this->entityManager->getRepository(Utilisateur::class)->findAll();
        return $this->json($utilisateurs);
    }

    /**
     * @Route("/utilisateur", name="utilisateur_create", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $utilisateur = new Utilisateur();
        $utilisateur->setNom($data['nom']);
        $utilisateur->setPrenom($data['prenom']);
        $utilisateur->setEmail($data['email']);
        $utilisateur->setMotDePasse($data['motDePasse']);

        $this->entityManager->persist($utilisateur);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Utilisateur created!'], JsonResponse::HTTP_CREATED);
    }

   /**
 * @Route("/utilisateur/{id}", name="utilisateur_show", methods={"GET"})
 */
public function show(int $id): JsonResponse
{
    $utilisateur = $this->entityManager->getRepository(Utilisateur::class)->find($id);

    if (!$utilisateur) {
        return new JsonResponse(['status' => 'Utilisateur not found!'], JsonResponse::HTTP_NOT_FOUND);
    }

    return $this->json($utilisateur);
}

    /**
     * @Route("/utilisateur/{id}", name="utilisateur_update", methods={"PUT"})
     */
    public function update(int $id, Request $request): JsonResponse
    {
        $utilisateur = $this->entityManager->getRepository(Utilisateur::class)->find($id);

        if (!$utilisateur) {
            return new JsonResponse(['status' => 'Utilisateur not found!'], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        $utilisateur->setNom($data['nom']);
        $utilisateur->setPrenom($data['prenom']);
        $utilisateur->setEmail($data['email']);
        $utilisateur->setMotDePasse($data['motDePasse']);

        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Utilisateur updated!'], JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/utilisateur/{id}", name="utilisateur_delete", methods={"DELETE"})
     */
    public function delete(int $id): JsonResponse
    {
        $utilisateur = $this->entityManager->getRepository(Utilisateur::class)->find($id);

        if (!$utilisateur) {
            return new JsonResponse(['status' => 'Utilisateur not found!'], JsonResponse::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($utilisateur);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Utilisateur deleted!'], JsonResponse::HTTP_OK);
    }
}

