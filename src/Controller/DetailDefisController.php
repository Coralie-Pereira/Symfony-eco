<?php

namespace App\Controller;

use App\Entity\Challenge;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;



class DetailDefisController extends AbstractController
{
    #[Route("/detail-defis/{challengeId}", name:"app_DetailDefisController")]
    public function main($challengeId)
    {
        //recuperer un challenge ou l'id cst 1 a utiliser que si jai une table 
       // $challenges = $this -> getDoctrine()->getRepository(Challenge::class)->findOneBy($challengeId);
        $lineCount = 0;
        if (($open = fopen("../data/ecogestes.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 1000, ",")) !== false) {
                if ($lineCount >= 2) {
                    $challenges[] = $data;
                }
                $lineCount++;
            }
            return $this->render('detail-defis.html.twig', ['detailDefis' => $challenges]);
            
        }
        // return $this->render('challenge-list.html.twig', ['challengeList' => [1,2,3]]);
    }

}