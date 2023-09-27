<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\InscriptionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class InscriptionController extends AbstractController
{
    #[Route("/inscription", name:"app_inscription")]
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
       $user = new User();
       $form = $this->createForm(InscriptionType::class, $user);
       
       $form->handleRequest($request); // hydratation du form 
       if($form->isSubmitted() && $form->isValid()){ // test si le formulaire a été soumis et s'il est valide
        $user -> setScore(16);
        $user->setPassword($passwordEncoder->encodePassword($user, $user->getPassword())); //Hash password
        $user -> setCreatedAt(new \DateTimeImmutable());
        
        $em = $this->getDoctrine()->getManager(); // on récupère la gestion des entités
        $em->persist($user); // on effectue les mise à jours internes
        $em->flush(); // on effectue la mise à jour vers la base de données
        return $this->redirectToRoute('app_challenge_list'); // on redirige vers la route show_task avec l'id du post créé ou modifié 
      }

      return $this->render('inscription.html.twig', ['form' => $form->createView()]);
    }

}