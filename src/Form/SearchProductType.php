<?php

namespace App\Form;


use App\Entity\Categories;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class SearchProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categories', EntityType::class, [
                // la classe avec qui je veut mapper sur le formulaire est Categories
                'class' => Categories::class,
                // le label je met a false car je les déffinie dans mon twig
                'label' => false,
                // et je dit que ce champs n'est pas requis
                'required' => false,
                //je met multiple a true afin que l'utilisateur puisse faire plusieurs choix de categories 
                'multiple' => true, 
                'attr' => [
                    'class' => 'js-categories-multiple'
                ]
            ])
            ->add('minprice', IntegerType::class,[
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'min...'
                ]
            ])
            ->add('maxprice', IntegerType::class,[
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'max...'
                ]
            ])

            ->add('tags', TextType::class,[
                'label' => false,
                'required' => false,
                'attr' =>[
                    'placeholder' => 'tags...'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
