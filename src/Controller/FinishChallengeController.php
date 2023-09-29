<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Challenge;
use App\Entity\UserChallenge;
use App\Form\UserChallengesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FinishChallengeController extends AbstractController
{
    // Action du contrôleur pour marquer un défi comme terminé
    #[Route("/finish-challenge/{user_challenge_id}", name: "app_finish_challenge")]
    public function finishUserChallenge(Request $request, $user_challenge_id)
    {
        // Récupérer l'entité UserChallenge correspondant à l'ID fourni
        $userChallenge = $this->getDoctrine()->getRepository(UserChallenge::class)->find($user_challenge_id);

        // Mettre à jour le statut du défi de l'utilisateur à "terminé" (statut 2)
        $userChallenge->setStatus(2);

        // Ajouter les points du défi terminé au score de l'utilisateur
        $this->addUserPoints($userChallenge->getChallenge()->getPoints());

        // Enregistrer les changements dans la base de données
        $em = $this->getDoctrine()->getManager();
        $em->persist($userChallenge);
        $em->flush();

        // Rediriger vers la liste des défis
        return $this->redirectToRoute('app_challenge_list');
    }

    // Méthode pour ajouter des points au score de l'utilisateur
    public function addUserPoints(int $challengePoints)
    {
        // Récupérer l'utilisateur actuel
        $user = $this->getUser();

        // Ajouter les points du défi au score de l'utilisateur
        $user->setScore($user->getScore() + $challengePoints);

        // Enregistrer les changements dans la base de données
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
    }
}
