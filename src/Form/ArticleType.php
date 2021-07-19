<?php

namespace App\Form;

use App\Entity\Tag;
use App\Entity\Article;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //* la fonction add permet de crée les champs du formulaire
        $builder
            // ->add('titre', TextareaType::class) //! on change le champ en area (importer la classe)
            // ->add('contenu', TextType::class, [ //! on change le champ en text (importer la classe)
            //     'attr' => [
            //         'placeholder' => "Contenu de l'article"
            //     ]
            // ])
            ->add('titre', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => "Saisir le titre de l'article",
                    // 'class' => 'nouvelle.classe.css btn ect', //! modifier l'apaprence malgré le yaml

                ]
            ])
            //* On définit le champ qui permet d'associer une catégorie à l'article dans le formulaire
            //* Ce champ provient d'une autre entité : Category
            ->add('category', EntityType::class, [
                'class' => Category::class, //? on précise de quelle entité provient ce champ
                'choice_label' => 'titre' //? le contenu de la liste déroulante sera le titre des catégories
            ])
            ->add('tags', EntityType::class, [
                'class' => Tag::class, //? on précise de quelle entité provient ce champ
                'choice_label' => 'title', //? liste toutes les données de l'entité
                'multiple' => true //? manytomany plsuieurs choix possible
            ])
            ->add('contenu', TextareaType::class, [
                'required' => false,
                'label' => "Détail de l'article", // change contenu en ceci
                'attr' => [
                    'placeholder' => "Contenu de l'article",
                    'rows' => 15
                ]
            ])
            ->add('image', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => "Saisir l'URL de l'image"
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
