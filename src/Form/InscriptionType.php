<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType; // Importation du bon type
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('pseudo', TextType::class, [
            //     'attr' => ['class' => 'text-3xl font-bold underline'],
            //     'label' => 'Username', // Le libellé du champ
            //     'label_attr' => ['class' => 'required'] // Les attributs du libellé
            // ])
            ->add('pseudo')
            ->add('email')
            ->add('password')
            ->add('add', SubmitType::class)
        ;
    }
}
?>