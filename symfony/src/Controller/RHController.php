<?php

namespace App\Controller;

use App\Entity\RH;
use App\Repository\RHRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/rh')]
class RHController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'rh_index', methods: ['GET'])]
    public function index(RHRepository $rhRepository): JsonResponse
    {
        $rhs = $rhRepository->findAll();
        return $this->json($rhs);
    }

    #[Route('/new', name: 'rh_new', methods: ['POST'])]
    public function new(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $rh = new RH();
        $rh->setUtilisateur($this->getUser());
        $rh->setRole($data['role']);

        $this->entityManager->persist($rh);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'RH created!'], JsonResponse::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'rh_show', methods: ['GET'])]
    public function show(RH $rh): JsonResponse
    {
        return $this->json($rh);
    }

    #[Route('/{id}/edit', name: 'rh_edit', methods: ['PUT'])]
    public function edit(Request $request, RH $rh): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $rh->setRole($data['role']);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'RH updated!'], JsonResponse::HTTP_OK);
    }

    #[Route('/{id}', name: 'rh_delete', methods: ['DELETE'])]
    public function delete(RH $rh): JsonResponse
    {
        $this->entityManager->remove($rh);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'RH deleted!'], JsonResponse::HTTP_OK);
    }
}
