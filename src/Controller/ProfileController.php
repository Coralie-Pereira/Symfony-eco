<?php

// src/Controller/ProfileController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Challenge;

class ProfileController extends AbstractController
{
    // Action pour afficher le profil de l'utilisateur
    #[Route("/profile", name:"app_profile")]
    public function ProfileController()
    {
        // Récupération des données de l'utilisateur à partir de la BDD
        $user = $this->getUser();
        if($user->getRoles())
    
        // Direction vers la page web appropriée en fonction de la présence de l'utilisateur
        if ($user) {
            // Récupérer les défis terminés de l'utilisateur
            $finishedChallenges = $this->getFinishChallenges();
            $nbFinishedChallenges = count($finishedChallenges);
            // Récupérer le nombre total de défis
            $totalChallenges = $this->getDoctrine()->getRepository(Challenge::class)->findAll();
            $nbTotalChallenges = count($totalChallenges);

            // Afficher la page de profil avec les données de l'utilisateur et les statistiques
            return $this->render('profile.html.twig', [
                'user' => $user,
                'nbFinishedChallenges' => $nbFinishedChallenges,
                'nbTotalChallenges' => $nbTotalChallenges
            ]);
        } else {
            // Si l'utilisateur n'est pas connecté, rediriger vers la page d'accueil
            return $this->render('home.html.twig');
        }
    }

    // Méthode pour récupérer les défis terminés de l'utilisateur
    public function getFinishChallenges()
    {
        $user = $this->getUser();
        $userFinishedChallenges = $user->getUserChallenges(); // Récupérer les défis de l'utilisateur
        $userFinishedChallengesArray = $userFinishedChallenges->toArray(); // Convertir en tableau
        foreach ($userFinishedChallengesArray as $key => $userChallengeArray) {
            if ($userChallengeArray->getStatus() != 2) {
                unset($userFinishedChallengesArray[$key]); // Supprimer les défis non terminés
            }
        }
        return $userFinishedChallengesArray; // Retourner les défis terminés de l'utilisateur
    }
}
