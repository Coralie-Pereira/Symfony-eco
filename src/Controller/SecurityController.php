<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    // Cette Route indique que cette méthode gère l'URL "/login" et a pour nom "app_login".
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // Récupère les éventuelles erreurs de connexion
        $error = $authenticationUtils->getLastAuthenticationError();
       // Récupère le dernier nom d'utilisateur (saisi par l'utilisateur)
        $lastUsername = $authenticationUtils->getLastUsername();

        // retourne la vue de la page web login en passant les informations d'erreur et le dernier nom d'utilisateur
        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    // Cette Route indique que cette méthode gère l'URL "/logout" et a pour nom "app_logout".
    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
       // Lance une exception pour indiquer que cette méthode peut rester vide
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
