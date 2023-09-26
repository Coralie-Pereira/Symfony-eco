<?php

namespace App\Controller;

use App\Entity\Challenge;
use App\Entity\User;
use App\Form\AdminType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class AdminController extends AbstractController
{
    #[Route("/admin", name:"app_admin")]
    public function main(Request $request)
    {
        
        $challenge = new Challenge();
        $challenge -> setCreatedAt(\DateTimeImmutable::createFromFormat("Y-m-d", '2004-06-07'));
        $challenge -> setDeadline(\DateTime::createFromFormat("Y-m-d", '2004-06-07'));
        
        $user = $this->getDoctrine()->getRepository(User::class)->find(1);

        $challenge -> setCreatedBy($user);
        $form = $this->createForm(AdminType::class, $challenge);
      

        $form->handleRequest($request); // hydratation du form 
        if($form->isSubmitted() && $form->isValid()){ // test si le formulaire a été soumis et s'il est valide
        $em = $this->getDoctrine()->getManager(); // on récupère la gestion des entités
        $em->persist($challenge); // on effectue les mise à jours internes
        $em->flush(); // on effectue la mise à jour vers la base de données
        }
    return $this->render('admin.html.twig', ['form' => $form->createView()]);
    }

}
