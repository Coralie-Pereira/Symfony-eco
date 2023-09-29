<?php

namespace App\Controller;

use App\Entity\UserChallenge;
use App\Entity\Challenge;
use App\Entity\User;
use App\Form\AdminChallengeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends AbstractController
{
    // Action du contrôleur pour afficher le panneau d'administration
    #[Route("/admin", name:"admin_pannel")]
    public function showPannel()
    {
        // Vérifier si l'utilisateur a le rôle "ROLE_ADMIN"
        if (!in_array('ROLE_ADMIN', $this->getUser()->getRoles(), true)) {
            return $this->redirectToRoute('app_home');
        }

        // Récupérer tous les défis depuis la base de données
        $challenges = $this->getDoctrine()->getRepository(Challenge::class)->findAll();

        // Rendre le template d'administration avec la liste des défis
        return $this->render('admin-pannel.html.twig', ['challengeList' => $challenges]);
    }

    // Action du contrôleur pour ajouter un défi (affiche le formulaire d'ajout)
    #[Route("/admin/add-challenge", name:"admin_add_challenge")]
    public function addChallenge(Request $request)
    {
        // Créer une nouvelle instance de l'entité Challenge
        $challenge = new Challenge();
        $challenge->setCreatedAt(\DateTimeImmutable::createFromFormat("Y-m-d", '2004-06-07'));
        $challenge->setDeadline(\DateTime::createFromFormat("Y-m-d", '2004-06-07'));

        // Récupérer un utilisateur (ex: avec ID 1) pour associer comme créateur du défi
        $user = $this->getDoctrine()->getRepository(User::class)->find(1);
        $challenge->setCreatedBy($user);

        // Créer un formulaire pour ajouter un défi
        $form = $this->createForm(AdminChallengeType::class, $challenge);

        $form->handleRequest($request); // Hydratation du formulaire

        // Si le formulaire est soumis et valide, enregistrer le défi dans la base de données
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager(); // Gestionnaire d'entités
            $em->persist($challenge); // Effectuer les mises à jour internes
            $em->flush(); // Effectuer la mise à jour dans la base de données
            return $this->redirectToRoute('admin_pannel');
        }

        // Afficher le formulaire pour ajouter un défi
        return $this->render('admin-challenge.html.twig', ['form' => $form->createView()]);
    }

    // Action du contrôleur pour éditer un défi (affiche le formulaire d'édition)
    #[Route("/admin/edit-challenge/{id}", name:"admin_edit_challenge")]
    public function editChallenge(Request $request, $id)
    {
        // Récupérer le défi à éditer en fonction de l'ID
        $challenge = $this->getDoctrine()->getRepository(Challenge::class)->find($id);

        // Créer un formulaire pour éditer un défi
        $form = $this->createForm(AdminChallengeType::class, $challenge);

        $form->handleRequest($request); // Hydratation du formulaire

        // Si le formulaire est soumis et valide, enregistrer les modifications dans la base de données
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager(); // Gestionnaire d'entités
            $em->flush(); // Effectuer la mise à jour dans la base de données
            return $this->redirectToRoute('admin_pannel');
        }

        // Afficher le formulaire pour éditer un défi
        return $this->render('admin-challenge.html.twig', ['form' => $form->createView()]);
    }

    // Action du contrôleur pour supprimer un défi
    #[Route("/admin/delete-challenge/{id}", name:"admin_delete_challenge")]
    public function deleteChallenge($id)
    {
        // Récupérer le défi à supprimer en fonction de l'ID
        $challenge = $this->getDoctrine()->getRepository(Challenge::class)->find($id);

        // Récupérer tous les UserChallenge associés à ce défi et les supprimer
        $usersChallenges =  $this->getDoctrine()->getRepository(UserChallenge::class)->findByChallenge($challenge->getId());
        foreach($usersChallenges as $userChallenge){
            $em = $this->getDoctrine()->getManager();
            $em->remove($userChallenge);
        }

        // Supprimer le défi
        $em = $this->getDoctrine()->getManager();
        $em->remove($challenge);
        $em->flush();

        // Rediriger vers le panneau d'administration
        return $this->redirectToRoute('admin_pannel');
    }
}
