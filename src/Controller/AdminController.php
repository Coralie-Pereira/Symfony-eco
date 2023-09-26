<?php

namespace App\Controller;

use App\Entity\Challenge;
use App\Entity\User;
use App\Form\AdminChallengeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class AdminController extends AbstractController
{
    #[Route("/admin/add-challenge", name:"admin_add_challenge")]
    public function addChallenge(Request $request)
    {
        
        $challenge = new Challenge();
        $challenge -> setCreatedAt(\DateTimeImmutable::createFromFormat("Y-m-d", '2004-06-07'));
        $challenge -> setDeadline(\DateTime::createFromFormat("Y-m-d", '2004-06-07'));
        
        $user = $this->getDoctrine()->getRepository(User::class)->find(1);

        $challenge -> setCreatedBy($user);
        $form = $this->createForm(AdminChallengeType::class, $challenge);
      

        $form->handleRequest($request); // hydratation du form 
        if($form->isSubmitted() && $form->isValid()){ // test si le formulaire a été soumis et s'il est valide
        $em = $this->getDoctrine()->getManager(); // on récupère la gestion des entités
        $em->persist($challenge); // on effectue les mise à jours internes
        $em->flush(); // on effectue la mise à jour vers la base de données
        }
    return $this->render('admin-challenge.html.twig', ['form' => $form->createView()]);
    }

    #[Route("/admin/edit-challenge", name:"admin_edit_challenge")]
    public function editChallenge(Request $request){
        $challenge = $this->getDoctrine()->getRepository(Challenge::class)->find(1);
        $form = $this->createForm(AdminChallengeType::class, $challenge);
        $form->handleRequest($request); // hydratation du form 
        if($form->isSubmitted() && $form->isValid()){ // test si le formulaire a été soumis et s'il est valide
            $em = $this->getDoctrine()->getManager(); // on récupère la gestion des entités
            $em->flush(); // on effectue la mise à jour vers la base de données
            }

        return $this->render('admin-challenge.html.twig', ['form' => $form->createView()]);
    }
    
}
