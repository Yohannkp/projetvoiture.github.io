<?php

namespace App\Form;

use App\Entity\Voiture;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('Marque')
            ->add('Model')
            ->add('NumSerie')
            ->add('NumeroIdentifiant')
            ->add('dateAchat',DateType::class,["widget" => "single_text"])
            ->add('couleur')
            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}
