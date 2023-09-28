<?php

namespace App\Controller;

use App\Entity\Challenge;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;



class ChallengeListController extends AbstractController
{
    #[Route("/challenge-list", name:"app_challenge_list")]
    public function main()
    {
        $userChallenges = [];
        if($this->getUser()!=null){
            $userChallenges = $this -> getCurrentChallenges();
        }
        $challenges = $this -> getDoctrine()->getRepository(Challenge::class)->findAll();
        return $this->render('challenge-list.html.twig', ['challengeList' => $challenges, 'userChallenges'=>$userChallenges]);
    }

    public function getCurrentChallenges(){
        $user = $this -> getUser();
        $userChallenges = $user -> getUserChallenges();
        $userChallengesArray = $userChallenges -> toArray();
        return $userChallengesArray;
    }
}