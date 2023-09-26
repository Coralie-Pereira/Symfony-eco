<?php

namespace App\Controller;

use App\Entity\Challenge;
use App\Form\AdminType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class AdminController extends AbstractController
{
    #[Route("/admin", name:"app_admin")]
    public function main()
    {
       $challenge = new Challenge();
       $form = $this->createForm(AdminType::class, $challenge);
       return $this->render('admin.html.twig', ['form' => $form->createView()]);
    }
}
