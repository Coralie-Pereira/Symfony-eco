<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

class ScoresController extends AbstractController
{
    // Action pour afficher les scores des utilisateurs
    #[Route("/scores", name:"app_scores")]
    public function ScoresController()
    {
        // Récupérer les utilisateurs triés par score (descendant)
        $users = $this->getDoctrine()->getRepository(User::class)->findBy([], ['score' => 'DESC']);

        // Récupérer l'utilisateur connecté
        $connecteduser = $this->getUser();
        
        // Afficher la page des scores avec la liste des utilisateurs et l'utilisateur connecté
        return $this->render('scores.html.twig', [
            'users' => $users,
            'connecteduser' => $connecteduser,
        ]);
    }
}
