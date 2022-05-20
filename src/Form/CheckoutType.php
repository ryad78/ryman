<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Carrier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CheckoutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // recupration de l'utilisateur afin de recuperer l'adresse et le transporteur choisi
       
        $user = $options['user'];

        $builder
            ->add('address', EntityType::class,[
                'class'=>Address::class,
                'required' =>true,
                'choices' => $user->getAddresses(),// la je recupère l'address mais il faut que je crée une function to_string dans l'entity address et carrier
                'multiple' => false,
                //j'ajoute une clé pour stylé et sa soit un checkbox
                'expanded' => true
            ])
            ->add('carrier', EntityType::class,[
                'class'=>Carrier::class,
                'required' =>true,
                'multiple' => false,
                //j'ajoute une clé pour stylé et sa soit un checkbox
                'expanded' => true
            ])
            
            ->add('informations', TextareaType::class, [
                'required'=> false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
            'user' => array(),
        ]);
    }
}
