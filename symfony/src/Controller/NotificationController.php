<?php

namespace App\Controller;

use App\Entity\Notification;
use App\Entity\RH;
use App\Repository\NotificationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/notification')]
class NotificationController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'notification_index', methods: ['GET'])]
    public function index(NotificationRepository $notificationRepository): JsonResponse
    {
        $notifications = $notificationRepository->findAll();
        return $this->json($notifications);
    }

    #[Route('/new', name: 'notification_new', methods: ['POST'])]
    public function new(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Assuming you get the RH ID from the request data
        $rh = $this->entityManager->getRepository(RH::class)->find($data['rh_id']);
        if (!$rh) {
            return new JsonResponse(['status' => 'RH not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $notification = new Notification();
        $notification->setMessage($data['message']);
        $notification->setDateDebut(new \DateTime($data['dateDebut']));
        $notification->setDateFin(new \DateTime($data['dateFin']));
        $notification->setRh($rh);

        $this->entityManager->persist($notification);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Notification created!'], JsonResponse::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'notification_show', methods: ['GET'])]
    public function show(Notification $notification): JsonResponse
    {
        return $this->json($notification);
    }

    #[Route('/{id}/edit', name: 'notification_edit', methods: ['PUT'])]
    public function edit(Request $request, Notification $notification): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $notification->setMessage($data['message']);
        $notification->setDateDebut(new \DateTime($data['dateDebut']));
        $notification->setDateFin(new \DateTime($data['dateFin']));

        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Notification updated!'], JsonResponse::HTTP_OK);
    }

    #[Route('/{id}', name: 'notification_delete', methods: ['DELETE'])]
    public function delete(Notification $notification): JsonResponse
    {
        $this->entityManager->remove($notification);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Notification deleted!'], JsonResponse::HTTP_OK);
    }
}
