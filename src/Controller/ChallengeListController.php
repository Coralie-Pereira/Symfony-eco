<?php

namespace App\Controller;

use App\Entity\Challenge;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ChallengeListController extends AbstractController
{
    // Variable pour stocker les défis
    private $challenges;

    // Action du contrôleur pour gérer la route "/challenge-list"
    #[Route("/challenge-list", name: "app_challenge_list")]
    public function main()
    {
        // Tableaux pour stocker les défis actuels et terminés de l'utilisateur
        $userCurrentChallenges = [];
        $userFinishChallenges = [];

        // Récupération de tous les défis depuis la base de données
        $this->challenges = $this->getDoctrine()->getRepository(Challenge::class)->findAll();

        // Vérifier si un utilisateur est connecté
        if ($this->getUser()) {
            // Récupérer les défis actuels de l'utilisateur
            $userCurrentChallenges = $this->getCurrentChallenges();
        }

        // Vérifier si un utilisateur est connecté
        if ($this->getUser()) {
            // Récupérer les défis terminés de l'utilisateur
            $userFinishChallenges = $this->getFinishChallenges();
        }

        // Renvoyer vers le template 'challenge-list.html.twig' en passant les données des défis
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
        $userChallenges = $user->getUserChallenges();
        $userChallengesArray = $userChallenges->toArray();

        // Filtrer les défis non actuels
        foreach ($userChallengesArray as $key => $userChallengeArray) {
            if ($userChallengeArray->getStatus() != 1) {
                unset($userChallengesArray[$key]);
            }

            // Supprimer les défis actuels de la liste globale des défis
            if (in_array($userChallengeArray->getChallenge(), $this->challenges)) {
                unset($this->challenges[array_search($userChallengeArray->getChallenge(), $this->challenges)]);
            }
        }

        return $userChallengesArray;
    }

    // Méthode pour récupérer les défis terminés de l'utilisateur
    public function getFinishChallenges()
    {
        $user = $this->getUser();
        $userChallenges = $user->getUserChallenges();
        $userChallengesArray = $userChallenges->toArray();

        // Filtrer les défis non terminés
        foreach ($userChallengesArray as $key => $userChallengeArray) {
            if ($userChallengeArray->getStatus() != 2) {
                unset($userChallengesArray[$key]);
            }

            // Supprimer les défis terminés de la liste globale des défis
            if (in_array($userChallengeArray->getChallenge(), $this->challenges)) {
                unset($this->challenges[array_search($userChallengeArray->getChallenge(), $this->challenges)]);
            }
        }

        return $userChallengesArray;
    }
}
