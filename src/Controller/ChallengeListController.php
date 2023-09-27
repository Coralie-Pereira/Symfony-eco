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
        // $challenges = $this -> getDoctrine()->getRepository(Challenge::class)->findAll();
        // return $this->render('challenge-list.html.twig', ['challengeList' => $challenges]);
        $lineCount = 0;
        if (($open = fopen("../data/ecogestes.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 1000, ",")) !== false) {
                if ($lineCount >= 2) {
                    $challenges[] = $data;
                }
                $lineCount++;
            }
            return $this->render('challenge-list.html.twig', ['challengeList' => $challenges]);
            
        }
    }

}