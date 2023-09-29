<?php

namespace App\Controller;

use App\Entity\Challenge;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

// Contrôleur pour la liste des défis et la gestion des défis pour un utilisateur

class ChallengeListController extends AbstractController
{
    private $challenges; // Liste des défis

    // Action pour afficher la liste des défis
    #[Route("/challenge-list", name: "app_challenge_list")]
    public function main()
    {
        $userCurrentChallenges = []; // Défis actuels de l'utilisateur
        $userFinishChallenges = []; // Défis terminés de l'utilisateur
        $this->challenges = $this->getDoctrine()->getRepository(Challenge::class)->findAll(); // Récupérer tous les défis

        // Vérifier si l'utilisateur est connecté
        if ($this->getUser()) {
            // Récupérer les défis actuels de l'utilisateur
            $userCurrentChallenges = $this->getCurrentChallenges();
            $userFinishChallenges = $this->getFinishChallenges();
        }
   

        // Afficher la liste des défis avec les défis actuels et terminés de l'utilisateur
        return $this->render('challenge-list.html.twig', [
            'challengeList' => $this->challenges,
            'userCurrentChallenges' => $userCurrentChallenges,
            'finishChallenges' => $userFinishChallenges
        ]);
    }

    // Méthode pour récupérer les défis actuels de l'utilisateur
    public function getCurrentChallenges()
    {
        $user = $this->getUser();
        $userChallenges = $user->getUserChallenges(); // Récupérer les défis de l'utilisateur
        $userChallengesArray = $userChallenges->toArray(); // Convertir en tableau
        foreach ($userChallengesArray as $key => $userChallengeArray) {
            if ($userChallengeArray->getStatus() != 1) {
                unset($userChallengesArray[$key]); // Supprimer les défis non 'en cours'
            }

            if (in_array($userChallengeArray->getChallenge(), $this->challenges)) {
                unset($this->challenges[array_search($userChallengeArray->getChallenge(), $this->challenges)]); // Supprimer les défis à faire de la liste des défis
            }
        }
        return $userChallengesArray; // Retourner les défis actuels de l'utilisateur
    }

    // Méthode pour récupérer les défis terminés de l'utilisateur
    public function getFinishChallenges()
    {
        $user = $this->getUser();
        $userChallenges = $user->getUserChallenges(); // Récupérer les défis de l'utilisateur
        $userChallengesArray = $userChallenges->toArray(); // Convertir en tableau
        foreach ($userChallengesArray as $key => $userChallengeArray) {
            if ($userChallengeArray->getStatus() != 2) {
                unset($userChallengesArray[$key]); // Supprimer les défis non terminés
            }
            if (in_array($userChallengeArray->getChallenge(), $this->challenges)) {
                unset($this->challenges[array_search($userChallengeArray->getChallenge(), $this->challenges)]); // Supprimer les défis à faire de la liste des défis
            }
        }
        return $userChallengesArray; // Retourner les défis terminés de l'utilisateur
    }
}
