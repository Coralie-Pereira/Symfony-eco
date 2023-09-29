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
    // Action du contrôleur pour gérer l'inscription d'un utilisateur
    #[Route("/inscription", name:"app_inscription")]
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // Créer une instance de l'entité User
        $user = new User();

        // Créer un formulaire d'inscription en utilisant le type de formulaire InscriptionType
        $form = $this->createForm(InscriptionType::class, $user);

        // Traiter la soumission du formulaire
        $form->handleRequest($request);

        // Vérifier si le formulaire a été soumis et est valide
        if($form->isSubmitted() && $form->isValid()) {
            // Récupérer le nom d'utilisateur et l'email saisis
            $username = $user->getUsername();
            $email = $user->getEmail();

            // Vérifier si le nom d'utilisateur existe déjà
            $existingUser = $this->getDoctrine()
                ->getRepository(User::class)
                ->findOneBy(['username' => $username]);

            // Vérifier si l'email existe déjà
            $existingEmail = $this->getDoctrine()
                ->getRepository(User::class)
                ->findOneBy(['email' => $email]);

            // Si le nom d'utilisateur ou l'email existe déjà, afficher des messages d'erreur
            if($existingUser) {
                $this->addFlash('error', 'Ce nom d\'utilisateur est déjà utilisé.');
            }

            if($existingEmail) {
                $this->addFlash('error', 'Cet email est déjà enregistré.');
            }

            if($existingUser || $existingEmail) {
                // Rediriger vers la page d'inscription avec les messages d'erreur
                return $this->render('inscription.html.twig', ['form' => $form->createView()]);
            }

            // Si le nom d'utilisateur et l'email sont uniques, procéder à l'ajout
            $user->setScore(10000);
            $user->setPassword($passwordEncoder->encodePassword($user, $user->getPassword()));
            $user->setCreatedAt(new \DateTimeImmutable());

            // Enregistrer l'utilisateur dans la base de données
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Inscription réussie !');
            // Rediriger vers la liste des défis après l'inscription
            return $this->redirectToRoute('app_challenge_list');
        }

        // Afficher le formulaire d'inscription
        return $this->render('inscription.html.twig', ['form' => $form->createView()]);
    }
}
