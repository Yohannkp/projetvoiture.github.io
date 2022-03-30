<?php

namespace App\Form;

use App\Entity\Voiture;
use App\Entity\Client;
use App\Entity\Vente;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use App\Repository\VoitureRepository;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class VenteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Montant')
            ->add('dateVente',DateType::class,["widget" => "single_text"])
            ->add('client', EntityType::class, ['class' => Client::class,
            'choice_label' => 'nom',
            'label' => 'Client',
            "attr" => ["class" => "form-control"]])
            ->add('voiture', EntityType::class, ['class' => Voiture::class ,
            'choice_label' => 'marque',
            'label' => 'Voiture',
            "attr" => ["class" => "form-control"]
             ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vente::class,
        ]);
    }
}
