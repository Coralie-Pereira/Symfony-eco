<?php

// src/Controller/ProfileController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;



class ProfileController extends AbstractController
{
    #[Route("/profile", name:"app_profile")]
    public function ProfileController()
    {
        // recupération de données de l'utilisateur à partir de la BDD
        $user = $this->getUser();
    
        //direction page web 
        return $this->render('profile.html.twig', [
            'user' => $user,
        ]);
    }
}
