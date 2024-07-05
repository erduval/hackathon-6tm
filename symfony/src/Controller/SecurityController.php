<?php
namespace App\Controller;

use App\Entity\Utilisateur;
use App\Entity\RH;
use App\Entity\Coopteur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class SecurityController extends AbstractController
{
    #[Route('/login', name: 'login', methods: ['POST'])]
    public function login(Request $request, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);
        $login = $data['login'];
        $password = $data['password'];

        $user = $entityManager->getRepository(Utilisateur::class)->findOneBy(['login' => $login]);

        if (!$user || !password_verify($password, $user->getPassword())) {
            return new Response('Invalid credentials', Response::HTTP_UNAUTHORIZED);
        }

        // Créer RH ou Coopteur selon le rôle de l'utilisateur s'il n'est pas déjà créé
        switch ($user->getRole()) {
            case 'ROLE_RH':
                if (!$entityManager->getRepository(RH::class)->findOneBy(['utilisateur' => $user])) {
                    $rh = new RH();
                    $rh->setUtilisateur($user);
                    $entityManager->persist($rh);
                    $entityManager->flush();
                }
                break;

            case 'ROLE_COOPTEUR':
                if (!$entityManager->getRepository(Coopteur::class)->findOneBy(['utilisateur' => $user])) {
                    $coopteur = new Coopteur();
                    $coopteur->setUtilisateur($user);
                    $entityManager->persist($coopteur);
                    $entityManager->flush();
                }
                break;
        }

        return $this->json([
            'role' => $user->getRole(),
            'message' => 'Login successful',
            'redirect' => $this->getRedirectUrlForRole($user->getRole())
        ]);
    }

    private function getRedirectUrlForRole(string $role): string
    {
        switch ($role) {
            case 'ROLE_RH':
                return '/home-rh';
            case 'ROLE_COOPTEUR':
                return '/home-coopteur';
            default:
                return '/home-default';
        }
    }
}

