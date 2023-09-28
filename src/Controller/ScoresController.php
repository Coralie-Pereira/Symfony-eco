<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

class ScoresController extends AbstractController
{
    #[Route("/scores", name:"app_scores")]
    public function ScoresController()
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findBy([], ['score' => 'DESC']);

        $connecteduser = $this->getUser();
        
        return $this->render('scores.html.twig', [
            'users' => $users,
            'connecteduser' => $connecteduser,
        ]);

    }
}