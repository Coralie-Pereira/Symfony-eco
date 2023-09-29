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
    #[Route("/add-challenge/{challenge_id}", name:"app_add_challenge")]
    public function addUserChallenge(Request $request, $challenge_id)
    {
        $user = $this-> getUser();
        $challenge = $this -> getDoctrine()->getRepository(Challenge::class)->find($challenge_id);
        $user_challenge = new UserChallenge();
        $user_challenge->setChallenge($challenge);
        $user_challenge->setUser($user);
        $user_challenge->setStatus(1);
        $user_challenge->setCreatedAt(new \DateTimeImmutable());
        $user ->addUserChallenge($user_challenge);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user_challenge); 
        $em->flush();

        return $this->redirectToRoute('app_challenge_list');
    } 
}