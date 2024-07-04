<?php

namespace App\Controller;

use App\Entity\RH;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RHController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/rhs", name="rh_index", methods={"GET"})
     */
    public function index(): JsonResponse
    {
        $rhs = $this->entityManager->getRepository(RH::class)->findAll();
        return $this->json($rhs);
    }

    /**
     * @Route("/rh", name="rh_create", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $rh = new RH();
        $rh->setUtilisateur($this->entityManager->getRepository(Utilisateur::class)->find($data['utilisateur_id']));

        $this->entityManager->persist($rh);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'RH created!'], JsonResponse::HTTP_CREATED);
    }

    /**
     * @Route("/rh/{id}", name="rh_show", methods={"GET"})
     */
    public function show(int $id): JsonResponse
    {
        $rh = $this->entityManager->getRepository(RH::class)->find($id);

        if (!$rh) {
            return new JsonResponse(['status' => 'RH not found!'], JsonResponse::HTTP_NOT_FOUND);
        }

        return $this->json($rh);
    }

    /**
     * @Route("/rh/{id}", name="rh_update", methods={"PUT"})
     */
    public function update(int $id, Request $request): JsonResponse
    {
        $rh = $this->entityManager->getRepository(RH::class)->find($id);

        if (!$rh) {
            return new JsonResponse(['status' => 'RH not found!'], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        $rh->setUtilisateur($this->entityManager->getRepository(Utilisateur::class)->find($data['utilisateur_id']));

        $this->entityManager->flush();

        return new JsonResponse(['status' => 'RH updated!'], JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/rh/{id}", name="rh_delete", methods={"DELETE"})
     */
    public function delete(int $id): JsonResponse
    {
        $rh = $this->entityManager->getRepository(RH::class)->find($id);

        if (!$rh) {
            return new JsonResponse(['status' => 'RH not found!'], JsonResponse::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($rh);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'RH deleted!'], JsonResponse::HTTP_OK);
    }
}
