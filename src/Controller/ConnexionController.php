<?php

namespace App\Controller;
// Use = importer
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ConnexionController extends AbstractController
{
    // création de route
    #[Route('/connexion',name: 'connexion')]
    public function new(Request $request)
    {

    
        // création de taches 
        $User = new User();
        $User->setUsername("coco");
        $User->setScore(500);
        $User->setCreatedAt(\DateTimeImmutable::createFromFormat("Y-m-d", '2004-06-07'));

        // RAJOUT MERCREDI MATIN CONNEXION
        $email = $request->request->get('email');
        $password = $request->request->get('password');
        //Géré l'authentification : Une fois vérifié avec succès les informations d'identification de l'utilisateur, on utilise le composant Symfony Security pour authentifier l'utilisateur.On utilise la classe TokenStorage pour cela.
        // $token = new User($User, null, 'main', $User->getRole());
        // $this->container->get('security.token_storage')->setToken($token);



        $form = $this->createFormBuilder($User)
            // ->add('task', TextType::class)
            // ->add('dueDate', DateType::class)

            // création du formulaire
             ->add('email')
            ->add('passWord',TextType::class,['label' => 'Mot de passe'])
            ->add('save', SubmitType::class)
            ->getForm();
        
             //récupération du formulaire pour pouvoir envoyer la connexion a la BDD
            $form->handleRequest($request); // hydratation du form 
            if($form->isSubmitted() && $form->isValid()){ // test si le formulaire a été soumis et s'il est valide
            $em = $this->getDoctrine()->getManager(); // on récupère la gestion des entités
            $em->persist($User); // on effectue les mise à jours internes
            $em->flush(); // on effectue la mise à jour vers la base de données
                    }



        //RAJOUT POUR LA CONNEXION MERCREDI MATIN
        //Pour verifier les infos d'identification et vérifier si l'utilisateur existe dans la base de données
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $user = $userRepository->findOneBy(['email' => $email]);

        //if (!$user || !$password->isPasswordValid($user, $password)) { // Gérer les erreurs d'authentification, par exemple, afficher un message d'erreur.
         //} 



         //redirection vers la route de la page web
        return $this->render('connexion.html.twig', array(
            'form' => $form->createView(),
        ));
        
    }

    
}


