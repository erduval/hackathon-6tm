<?php

namespace App\Controller;

use App\Entity\Cooptation;
use App\Entity\Coopteur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CooptationController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/cooptations", name="cooptation_index", methods={"GET"})
     */
    public function index(): JsonResponse
    {
        $cooptations = $this->entityManager->getRepository(Cooptation::class)->findAll();
        return $this->json($cooptations);
    }

    /**
     * @Route("/cooptation", name="cooptation_create", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $cooptation = new Cooptation();
        $cooptation->setDateCooptation(new \DateTime($data['dateCooptation']));
        $cooptation->setStatut($data['statut']);
        $cooptation->setCoopteur($this->entityManager->getRepository(Coopteur::class)->find($data['coopteur_id']));

        $this->entityManager->persist($cooptation);
        $this->updatePoints($cooptation);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Cooptation created!'], JsonResponse::HTTP_CREATED);
    }

    /**
     * @Route("/cooptation/{id}", name="cooptation_show", methods={"GET"})
     */
    public function show(int $id): JsonResponse
    {
        $cooptation = $this->entityManager->getRepository(Cooptation::class)->find($id);

        if (!$cooptation) {
            return new JsonResponse(['status' => 'Cooptation not found!'], JsonResponse::HTTP_NOT_FOUND);
        }

        return $this->json($cooptation);
    }

    /**
     * @Route("/cooptation/{id}", name="cooptation_update", methods={"PUT"})
     */
    public function update(int $id, Request $request): JsonResponse
    {
        $cooptation = $this->entityManager->getRepository(Cooptation::class)->find($id);

        if (!$cooptation) {
            return new JsonResponse(['status' => 'Cooptation not found!'], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        $cooptation->setDateCooptation(new \DateTime($data['dateCooptation']));
        $cooptation->setStatut($data['statut']);
        $cooptation->setCoopteur($this->entityManager->getRepository(Coopteur::class)->find($data['coopteur_id']));
        $this->updatePoints($cooptation);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Cooptation updated!'], JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/cooptation/{id}", name="cooptation_delete", methods={"DELETE"})
     */
    public function delete(int $id): JsonResponse
    {
        $cooptation = $this->entityManager->getRepository(Cooptation::class)->find($id);

        if (!$cooptation) {
            return new JsonResponse(['status' => 'Cooptation not found!'], JsonResponse::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($cooptation);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Cooptation deleted!'], JsonResponse::HTTP_OK);
    }

    private function updatePoints(Cooptation $cooptation): void
    {
        $points = 0;
        switch ($cooptation->getStatut()) {
            case 'GO':
                $points = 1;
                break;
            case 'NO GO':
                $points = 0;
                break;
            case 'Bonus Challenge':
                $points = 3;
                break;
            case 'Préqualification téléphonique':
                $points = 2;
                break;
            case 'Entretien RH':
                $points = 2;
                break;
            case 'Entretien Manager':
                $points = 3;
                break;
            case 'Candidat recruté':
                $points = 5;
                break;
        }

        $coopteur = $cooptation->getCoopteur();
        $coopteur->setPoints($coopteur->getPoints() + $points);
        $this->entityManager->persist($coopteur);

        foreach ($coopteur->getUtilisateur()->getEquipeUtilisateurs() as $equipeUtilisateur) {
            $equipe = $equipeUtilisateur->getEquipe();
            $equipe->updatePoints();
            $this->entityManager->persist($equipe);
        }
    }
}
