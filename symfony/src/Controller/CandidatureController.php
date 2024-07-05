<?php

namespace App\Controller;

use App\Entity\Candidature;
use App\Entity\Coopteur;
use App\Entity\Cooptation;
use App\Entity\OffreEmploi;
use App\Repository\CandidatureRepository;
use App\Service\CandidatureService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CandidatureController extends AbstractController
{
    private $entityManager;
    private $candidatureService;

    public function __construct(EntityManagerInterface $entityManager, CandidatureService $candidatureService)
    {
        $this->entityManager = $entityManager;
        $this->candidatureService = $candidatureService;
    }

    #[Route('/candidature', name: 'candidature_index', methods: ['GET'])]
    public function index(CandidatureRepository $candidatureRepository): JsonResponse
    {
        $candidatures = $candidatureRepository->findAll();
        return $this->json($candidatures);
    }

    #[Route('/candidature', name: 'candidature_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $coopteur = $this->entityManager->getRepository(Coopteur::class)->find($data['coopteur_id']);

        if (!$coopteur) {
            return new JsonResponse(['status' => 'Coopteur not found!'], JsonResponse::HTTP_NOT_FOUND);
        }

        $offreEmploi = $this->entityManager->getRepository(OffreEmploi::class)->find($data['offre_emploi_id']);

        if (!$offreEmploi) {
            return new JsonResponse(['status' => 'Offre emploi not found!'], JsonResponse::HTTP_NOT_FOUND);
        }

        $candidature = new Candidature();
        $candidature->setNom($data['nom']);
        $candidature->setPrenom($data['prenom']);
        $candidature->setEmail($data['email']);
        $candidature->setTelephone($data['telephone']);
        $candidature->setDomaine($data['domaine']);
        $candidature->setCv($data['cv']);
        $candidature->setLien($data['lien']);
        $candidature->setStatut('Nouveau');
        $candidature->setCreatedAt(new \DateTime());
        $candidature->setCoopteur($coopteur);
        $candidature->setOffreEmploi($offreEmploi);

        // Créer la cooptation associée
        $cooptation = new Cooptation();
        $cooptation->setCoopteur($coopteur);
        $cooptation->setDateCooptation(new \DateTime());
        $cooptation->setStatut('Nouveau');
        $cooptation->setCandidature($candidature);

        $this->entityManager->persist($candidature);
        $this->entityManager->persist($cooptation);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Candidature and Cooptation created!'], JsonResponse::HTTP_CREATED);
    }

    #[Route('/candidature/{id}/no_go', name: 'candidature_update_no_go', methods: ['PUT'])]
    public function updateNoGo(int $id, CandidatureRepository $candidatureRepository): JsonResponse
    {
        return $this->updateStatut($id, 'no go', $candidatureRepository);
    }

    #[Route('/candidature/{id}/go', name: 'candidature_update_go', methods: ['PUT'])]
    public function updateGo(int $id, CandidatureRepository $candidatureRepository): JsonResponse
    {
        return $this->updateStatut($id, 'go', $candidatureRepository);
    }

    #[Route('/candidature/{id}/precal_tele', name: 'candidature_update_precal_tele', methods: ['PUT'])]
    public function updatePrecalTele(int $id, CandidatureRepository $candidatureRepository): JsonResponse
    {
        return $this->updateStatut($id, 'Precal Tele', $candidatureRepository);
    }

    #[Route('/candidature/{id}/entretien_rh', name: 'candidature_update_entretien_rh', methods: ['PUT'])]
    public function updateEntretienRH(int $id, CandidatureRepository $candidatureRepository): JsonResponse
    {
        return $this->updateStatut($id, 'Entretien RH', $candidatureRepository);
    }

    #[Route('/candidature/{id}/entretien_manager', name: 'candidature_update_entretien_manager', methods: ['PUT'])]
    public function updateEntretienManager(int $id, CandidatureRepository $candidatureRepository): JsonResponse
    {
        return $this->updateStatut($id, 'Entretien Manager', $candidatureRepository);
    }

    #[Route('/candidature/{id}/recrute', name: 'candidature_update_recrute', methods: ['PUT'])]
    public function updateRecrute(int $id, CandidatureRepository $candidatureRepository): JsonResponse
    {
        return $this->updateStatut($id, 'Recruté', $candidatureRepository);
    }

    private function updateStatut(int $id, string $statut, CandidatureRepository $candidatureRepository): JsonResponse
    {
        $candidature = $candidatureRepository->find($id);

        if (!$candidature) {
            return new JsonResponse(['status' => 'Candidature not found!'], JsonResponse::HTTP_NOT_FOUND);
        }

        $this->candidatureService->updateStatut($candidature, $statut);

        return new JsonResponse(['status' => 'Candidature updated to ' . $statut . '!'], JsonResponse::HTTP_OK);
    }
}


