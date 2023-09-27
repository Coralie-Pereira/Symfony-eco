<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    #[Route("/", name:"app_home")]
    public function main()
    {
       return $this->render('home.html.twig');
    }
    
}