<?php

namespace App\Controller;

use App\Entity\Coopteur;
use App\Repository\CoopteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/coopteur')]
class CoopteurController extends AbstractController
{
    #[Route('/', name: 'coopteur_index', methods: ['GET'])]
    public function index(CoopteurRepository $coopteurRepository): Response
    {
        return $this->json($coopteurRepository->findAll());
    }

    #[Route('/new', name: 'coopteur_new', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);
        $coopteur = new Coopteur();
        $coopteur->setPoints($data['points']);
        // Assuming you get the utilisateur entity by ID or another means
        $utilisateur = $entityManager->getRepository(Utilisateur::class)->find($data['utilisateur_id']);
        $coopteur->setUtilisateur($utilisateur);

        $entityManager->persist($coopteur);
        $entityManager->flush();

        return $this->json($coopteur);
    }

    #[Route('/{id}', name: 'coopteur_show', methods: ['GET'])]
    public function show(Coopteur $coopteur): Response
    {
        return $this->json($coopteur);
    }

    #[Route('/{id}/edit', name: 'coopteur_edit', methods: ['PUT'])]
    public function edit(Request $request, Coopteur $coopteur, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);
        $coopteur->setPoints($data['points']);
        // Assuming you get the utilisateur entity by ID or another means
        $utilisateur = $entityManager->getRepository(Utilisateur::class)->find($data['utilisateur_id']);
        $coopteur->setUtilisateur($utilisateur);

        $entityManager->flush();

        return $this->json($coopteur);
    }

    #[Route('/{id}', name: 'coopteur_delete', methods: ['DELETE'])]
    public function delete(Coopteur $coopteur, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($coopteur);
        $entityManager->flush();

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
