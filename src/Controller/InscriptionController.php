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

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $username = $user->getUsername();
            $email = $user->getEmail();

            $existingUser = $this->getDoctrine()
                ->getRepository(User::class)
                ->findOneBy(['username' => $username]);

            $existingEmail = $this->getDoctrine()
                ->getRepository(User::class)
                ->findOneBy(['email' => $email]);

            if($existingUser) {
                // Le nom d'utilisateur existe déjà
                $this->addFlash('error', 'Ce nom d\'utilisateur est déjà utilisé.');
            }

            if($existingEmail) {
                // L'email existe déjà
                $this->addFlash('error', 'Cet email est déjà enregistré.');
            }

            if($existingUser || $existingEmail) {
                // Rediriger vers la page d'inscription avec les messages d'erreur
                return $this->render('inscription.html.twig', ['form' => $form->createView()]);
            }

            // Le nom d'utilisateur et l'email n'existent pas encore, procédez à l'ajout
            $user->setScore(10000);
            $user->setPassword($passwordEncoder->encodePassword($user, $user->getPassword()));
            $user->setCreatedAt(new \DateTimeImmutable());
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Inscription réussie !');
            return $this->redirectToRoute('app_challenge_list');
        }

        return $this->render('inscription.html.twig', ['form' => $form->createView()]);
    }
}
