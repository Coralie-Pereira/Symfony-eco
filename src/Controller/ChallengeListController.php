<?php

namespace App\Controller;

use App\Entity\Challenge;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;



class ChallengeListController extends AbstractController
{

    public function createChallenge($data){
        $challenge = new Challenge();
        $challenge->setTitle($data[1]);
        $challenge->setCategory($data[2]);
        $challenge->setSubcategory($data[3]);
        $challenge->setDescription($data[5]);
        $challenge -> setPoints(rand(5,15));
        $challenge -> setCreatedAt(new \DateTimeImmutable());
        $challenge -> setDeadline(new \DateTimeImmutable());
        $challenge -> setCreatedBy($this->getUser());
        $em = $this->getDoctrine()->getManager(); // on récupère la gestion des entités
        $em->persist($challenge); // on effectue les mise à jours internes
        $em->flush(); // on effectue la mise à jour vers la base de données
    }

    #[Route("/challenge-list", name:"app_challenge_list")]
    public function main()
    {
        // $challenges = $this -> getDoctrine()->getRepository(Challenge::class)->findAll();
        $lineCount = 0;
        if (($open = fopen("../data/ecogestes.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 1000, ",")) !== false) {
                if ($lineCount >= 2) {
                    $challenges[] = $data;
                    if(!empty($data[1])){
                       $this -> createChallenge($data);
                    }
                }
                
                $lineCount++;
            }
            return $this->render('challenge-list.html.twig', ['challengeList' => $challenges]);
            
        }
        // return $this->render('challenge-list.html.twig', ['challengeList' => [1,2,3]]);
    }

}