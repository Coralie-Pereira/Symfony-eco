<?php

namespace App\Controller;
use App\Entity\User;
use App\Entity\UserChallenges;
use App\Form\UserChallengesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserChallengesController extends AbstractController
{
    #[Route("/list-challenge", name:"app_user_challenges")]
    public function userChallenges(Request $request)
    {
        $userchallenge = new UserChallenges();
        $form = $this->createForm(UserChallengesType::class, $userchallenge);
    
        $form->handleRequest($request);
        $user = $this-> getUser();
        if ($form->isSubmitted() && $form->isValid()) {
            $challenges = $user->getChallenges();
            dump("test");
            dump($challenges);
            die;
            $status = $userchallenge->setStatus(1); // Changez la valeur du statut selon vos besoins
    
            $em = $this->getDoctrine()->getManager();
            $em->persist($userchallenge);
            $em->flush();
    
            $this->addFlash('success', 'Statut changé !');
        }
    
        return $this->render('list-challenge.html.twig', ['form' => $form->createView()]);
    }
}