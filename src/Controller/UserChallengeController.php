<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Challenge;
use App\Entity\UserChallenge;
use App\Form\UserChallengesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserChallengeController extends AbstractController
{
    // Action du contrôleur pour ajouter un défi à l'utilisateur
    #[Route("/add-challenge/{challenge_id}", name:"app_add_challenge")]
    public function addUserChallenge(Request $request, $challenge_id)
    {
        // Récupérer l'utilisateur actuel
        $user = $this-> getUser();

        // Récupérer le défi à partir de l'ID du défi
        $challenge = $this -> getDoctrine()->getRepository(Challenge::class)->find($challenge_id);

        // Créer une instance de l'entité UserChallenge
        $user_challenge = new UserChallenge();

        // Définir le défi et l'utilisateur associés au UserChallenge
        $user_challenge->setChallenge($challenge);
        $user_challenge->setUser($user);
        
        // Définir le statut du UserChallenge (1 pour "en cours")
        $user_challenge->setStatus(1);

        // Définir la date de création du UserChallenge
        $user_challenge->setCreatedAt(new \DateTimeImmutable());

        // Ajouter le UserChallenge à la liste des UserChallenges de l'utilisateur
        $user->addUserChallenge($user_challenge);

        // Enregistrer le UserChallenge dans la base de données
        $em = $this->getDoctrine()->getManager();
        $em->persist($user_challenge); 
        $em->flush();

        // Rediriger vers la liste des défis
        return $this->redirectToRoute('app_challenge_list');
    } 
}
