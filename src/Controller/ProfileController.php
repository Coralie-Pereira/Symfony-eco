<?php

// src/Controller/ProfileController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Challenge;



class ProfileController extends AbstractController
{
    #[Route("/profile", name:"app_profile")]
    public function ProfileController()
    {
        // recupération de données de l'utilisateur à partir de la BDD
        $user = $this->getUser();
    
        //direction page web 
        if ($user){

            $finishedChallenges = $this->getFinishChallenges();
            $nbFinishedChallenges = count($finishedChallenges);
            $totalChallenges = $this->getDoctrine()->getRepository(Challenge::class)->findAll();
            $nbTotalChallenges = count($totalChallenges);

            return $this->render('profile.html.twig', ['user' => $user, 'nbFinishedChallenges'=>$nbFinishedChallenges, 'nbTotalChallenges'=>$nbTotalChallenges]);
        }else{
            return $this->render('home.html.twig');
        }
        
    }

    public function getFinishChallenges()
    {
        $user = $this->getUser();
        $userFinishedChallenges = $user->getUserChallenges();
        $userFinishedChallengesArray = $userFinishedChallenges->toArray();
        foreach ($userFinishedChallengesArray as $key => $userChallengeArray) {
            if ($userChallengeArray->getStatus() != 2) {
                unset($userFinishedChallengesArray[$key]);
            }
        }
        return $userFinishedChallengesArray;
    }
}
