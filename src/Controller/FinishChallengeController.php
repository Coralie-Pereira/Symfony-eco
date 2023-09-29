<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Challenge;
use App\Entity\UserChallenge;
use App\Form\UserChallengesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

// Contrôleur pour gérer la fin d'un défi et mettre à jour les points de l'utilisateur

class FinishChallengeController extends AbstractController
{
    // Action pour marquer un défi comme terminé
    #[Route("/finish-challenge/{user_challenge_id}", name: "app_finish_challenge")]
    public function finishUserChallenge(Request $request, $user_challenge_id)
    {
        // Récupérer le UserChallenge à partir de l'ID
        $userChallenge = $this->getDoctrine()->getRepository(UserChallenge::class)->find($user_challenge_id);

        // Mettre à jour le statut du UserChallenge comme terminé
        $userChallenge->setStatus(2);

        // Ajouter les points du défi aux points de l'utilisateur
        $this->addUserPoints($userChallenge->getChallenge()->getPoints());

        $em = $this->getDoctrine()->getManager();
        $em->persist($userChallenge);
        $em->flush(); // Effectuer la mise à jour dans la base de données

        // Rediriger vers la liste des défis
        return $this->redirectToRoute('app_challenge_list');
    }

    // Méthode pour ajouter les points du défi aux points de l'utilisateur
    public function addUserPoints(int $challengePoints)
    {
        $user = $this->getUser(); // Récupérer l'utilisateur actuel
        $user->setScore($user->getScore() + $challengePoints); // Mettre à jour le score de l'utilisateur
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush(); // Effectuer la mise à jour dans la base de données
    }
}
