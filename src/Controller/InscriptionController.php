<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\InscriptionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends AbstractController
{
    #[Route("/inscription", name:"app_inscription")]
    public function main(Request $request)
    {
       $user = new User();
       $form = $this->createForm(InscriptionType::class, $user);
       
       $form->handleRequest($request); // hydratation du form 
       if($form->isSubmitted() && $form->isValid()){ // test si le formulaire a été soumis et s'il est valide
        $em = $this->getDoctrine()->getManager(); // on récupère la gestion des entités
        // $user -> setRole(0);
        $user -> setScore(0);
        $user -> setCreatedAt(new \DateTimeImmutable());
        $em->persist($user); // on effectue les mise à jours internes
        $em->flush(); // on effectue la mise à jour vers la base de données
        return $this->redirectToRoute('route_username', ['username' => $user->getUsername()]); // on redirige vers la route show_task avec l'id du post créé ou modifié 
      }
      
      return $this->render('inscription.html.twig', ['form' => $form->createView()]);
      // return $this->redirectToRoute('route_username', ['username' => $user->getPseudo()]);
    }

    /**
     * @Route("/{username}", name="route_username")
     */
    public function username($username)
    {
        return $this->render('profile.html.twig', ['username' => $username]);
    }
}