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
    #[Route("/admin", name:"admin_pannel")]
    public function showPannel(){
        return $this->render('admin-pannel.html.twig');
    }


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
        return $this->redirectToRoute('admin_pannel');
        }
    return $this->render('admin-challenge.html.twig', ['form' => $form->createView()]);
    }

    #[Route("/admin/edit-challenge/{id}", name:"admin_edit_challenge")]
    public function editChallenge(Request $request, $id){
        $challenge = $this->getDoctrine()->getRepository(Challenge::class)->find($id);
        $form = $this->createForm(AdminChallengeType::class, $challenge);
        $form->handleRequest($request); // hydratation du form 
        if($form->isSubmitted() && $form->isValid()){ // test si le formulaire a été soumis et s'il est valide
            $em = $this->getDoctrine()->getManager(); // on récupère la gestion des entités
            $em->flush(); // on effectue la mise à jour vers la base de données
            return $this->redirectToRoute('admin_pannel');
            }

        return $this->render('admin-challenge.html.twig', ['form' => $form->createView()]);
    }
    
    #[Route("/admin/delete-challenge/{id}", name:"admin_delete_challenge")]
    public function deleteChallenge($id){
        $challenge = $this->getDoctrine()->getRepository(Challenge::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($challenge);
        $em->flush();
        return $this->redirectToRoute('admin_pannel');
    }
}
