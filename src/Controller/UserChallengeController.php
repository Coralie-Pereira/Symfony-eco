<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Challenge;
use App\Entity\UserChallenge;
use App\Form\UserChallengesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

// Contrôleur pour gérer l'ajout d'un défi pour un utilisateur

class UserChallengeController extends AbstractController
{
    // Action pour ajouter un défi à un utilisateur
    #[Route("/add-challenge/{challenge_id}", name:"app_add_challenge")]
    public function addUserChallenge(Request $request, $challenge_id)
    {
        $user = $this-> getUser(); // Récupérer l'utilisateur actuel
        $challenge = $this->getDoctrine()->getRepository(Challenge::class)->find($challenge_id); // Récupérer le défi par son ID

        // Créer une nouvelle relation entre l'utilisateur et le défi
        $user_challenge = new UserChallenge();
        $user_challenge->setChallenge($challenge);
        $user_challenge->setUser($user);
        $user_challenge->setStatus(1); // Définir le statut du défi pour l'utilisateur
        $user_challenge->setCreatedAt(new \DateTimeImmutable()); // Définir la date de création

        // Ajouter la relation à l'utilisateur
        $user->addUserChallenge($user_challenge);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user_challenge); // Persister la relation
        $em->flush(); // Effectuer la mise à jour dans la base de données

        // Rediriger vers la liste des défis
        return $this->redirectToRoute('app_challenge_list');
    } 
}
