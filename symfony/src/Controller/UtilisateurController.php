<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/utilisateur')]
class UtilisateurController extends AbstractController
{
    #[Route('/', name: 'utilisateur_index', methods: ['GET'])]
    public function index(UtilisateurRepository $utilisateurRepository): Response
    {
        return $this->json($utilisateurRepository->findAll());
    }

    #[Route('/new', name: 'utilisateur_new', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);
        $utilisateur = new Utilisateur();
        $utilisateur->setLogin($data['login']);
        $utilisateur->setPassword(password_hash($data['password'], PASSWORD_BCRYPT));
        $utilisateur->setRole($data['role']);
        $utilisateur->setNom($data['nom']);
        $utilisateur->setPrenom($data['prenom']);

        $entityManager->persist($utilisateur);
        $entityManager->flush();

        return $this->json($utilisateur);
    }

    #[Route('/{id}', name: 'utilisateur_show', methods: ['GET'])]
    public function show(Utilisateur $utilisateur): Response
    {
        return $this->json($utilisateur);
    }

    #[Route('/{id}/edit', name: 'utilisateur_edit', methods: ['PUT'])]
    public function edit(Request $request, Utilisateur $utilisateur, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);
        $utilisateur->setLogin($data['login']);
        if (isset($data['password'])) {
            $utilisateur->setPassword(password_hash($data['password'], PASSWORD_BCRYPT));
        }
        $utilisateur->setRole($data['role']);
        $utilisateur->setNom($data['nom']);
        $utilisateur->setPrenom($data['prenom']);

        $entityManager->flush();

        return $this->json($utilisateur);
    }

    #[Route('/{id}', name: 'utilisateur_delete', methods: ['DELETE'])]
    public function delete(Utilisateur $utilisateur, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($utilisateur);
        $entityManager->flush();

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
