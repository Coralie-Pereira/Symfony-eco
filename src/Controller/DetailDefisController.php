<?php

namespace App\Controller;

use App\Entity\Challenge;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;



class DetailDefisController extends AbstractController
{
    #[Route("/detail-defis/{challengeId}", name:"app_details_defi")]
    public function main($challengeId)
    {
        //recuperer un challenge ou l'id cst 1 a utiliser que si jai une table 
       $challenge = $this -> getDoctrine()->getRepository(Challenge::class)->find($challengeId);
       return $this->render('detail-defis.html.twig', ['detailDefis' => $challenge]);

    }

}


