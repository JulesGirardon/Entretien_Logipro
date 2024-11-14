<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

// Formulaire pour les livres
class BookType extends AbstractType
{
    // Création des champs du formulaire et $builder permet la construction du formulaire
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        // Ajout des champs du formulaire
        $builder
            ->add('title', TextType::class) // titre
            ->add('author', TextType::class) // auteur
            ->add('genre', TextType::class) // genre
            ->add('isAvailable', CheckboxType::class, [ // checkbox permettant de savoir si le livre est disponible
                'label'    => 'Is available',
                'required' => false,
                'mapped'   => true, // Cela permet de dire que ce champ correspond directement à une propriété de Book. Meme si par défaut true, ceci permet de clarifier
            ]);
    }

    // Permet de configurer les options par défaut du formulaire
    public function configureOptions(OptionsResolver $resolver) : void
    {
        // Cela permet de "lier" le formulaire à une instance de Book
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
