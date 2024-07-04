<?php

namespace App\Controller;

use App\Entity\Notification;
use App\Entity\RH;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NotificationController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/notifications", name="notification_index", methods={"GET"})
     */
    public function index(): JsonResponse
    {
        $notifications = $this->entityManager->getRepository(Notification::class)->findAll();
        return $this->json($notifications);
    }

    /**
     * @Route("/notification", name="notification_create", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $notification = new Notification();
        $notification->setMessage($data['message']);
        $notification->setDateDebut(new \DateTime($data['dateDebut']));
        $notification->setDateFin(new \DateTime($data['dateFin']));
        $notification->setRh($this->entityManager->getRepository(RH::class)->find($data['rh_id']));

        $this->entityManager->persist($notification);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Notification created!'], JsonResponse::HTTP_CREATED);
    }

    /**
     * @Route("/notification/{id}", name="notification_show", methods={"GET"})
     */
    public function show(int $id): JsonResponse
    {
        $notification = $this->entityManager->getRepository(Notification::class)->find($id);

        if (!$notification) {
            return new JsonResponse(['status' => 'Notification not found!'], JsonResponse::HTTP_NOT_FOUND);
        }

        return $this->json($notification);
    }

    /**
     * @Route("/notification/{id}", name="notification_update", methods={"PUT"})
     */
    public function update(int $id, Request $request): JsonResponse
    {
        $notification = $this->entityManager->getRepository(Notification::class)->find($id);

        if (!$notification) {
            return new JsonResponse(['status' => 'Notification not found!'], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        $notification->setMessage($data['message']);
        $notification->setDateDebut(new \DateTime($data['dateDebut']));
        $notification->setDateFin(new \DateTime($data['dateFin']));
        $notification->setRh($this->entityManager->getRepository(RH::class)->find($data['rh_id']));

        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Notification updated!'], JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/notification/{id}", name="notification_delete", methods={"DELETE"})
     */
    public function delete(int $id): JsonResponse
    {
        $notification = $this->entityManager->getRepository(Notification::class)->find($id);

        if (!$notification) {
            return new JsonResponse(['status' => 'Notification not found!'], JsonResponse::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($notification);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Notification deleted!'], JsonResponse::HTTP_OK);
    }
}

