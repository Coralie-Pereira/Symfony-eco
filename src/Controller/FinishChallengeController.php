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
    #[Route("/finish-challenge/{user_challenge_id}", name: "app_finish_challenge")]
    public function finishUserChallenge(Request $request, $user_challenge_id)
    {

        $userChallenge = $this->getDoctrine()->getRepository(UserChallenge::class)->find($user_challenge_id);
        $userChallenge->setStatus(2);
        $this->addUserPoints($userChallenge->getChallenge()->getPoints());
        $em = $this->getDoctrine()->getManager();
        $em->persist($userChallenge);
        $em->flush();

        return $this->redirectToRoute('app_challenge_list');
    }

    public function addUserPoints(int $challengePoints)
    {
        $user = $this->getUser();
        $user->setScore($user->getScore() + $challengePoints);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
    }


}