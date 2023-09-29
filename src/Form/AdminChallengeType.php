<?php
// Définition de l'espace de noms du formulaire dans l'application Symfony.
namespace App\Form;

// Importation des classes nécessaires pour définir un formulaire Symfony.
use Symfony\Component\Form\AbstractType; // Classe de base pour créer des types de formulaire personnalisés.
use Symfony\Component\Form\FormBuilderInterface; // Interface pour construire un formulaire.
use Symfony\Component\Form\Extension\Core\Type\SubmitType; // Type de champ pour un bouton de soumission.

// Déclaration de la classe AdminChallengeType qui étend AbstractType.
class AdminChallengeType extends AbstractType
{
    // Méthode pour construire le formulaire.
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Ajout d'un champ "title" dans le formulaire.
        $builder->add('title');

        // Ajout d'un champ "description" dans le formulaire.
        $builder->add('description');

        // Ajout d'un champ "category" dans le formulaire.
        $builder->add('category');

        // Ajout d'un champ "subcategory" dans le formulaire.
        $builder->add('subcategory');

        // Ajout d'un champ "points" dans le formulaire.
        $builder->add('points');

        // Ajout d'un bouton de soumission avec le libellé "add".
        $builder->add('add', SubmitType::class);
    }
}
?>
