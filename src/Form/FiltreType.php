<?php

namespace App\Form;

use App\Entity\Race;
use App\Entity\Classe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class FiltreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('minPower', IntegerType::class, [
                'required' => false,
                'label' => 'Puissance minimale'
            ])
            ->add('race', EntityType::class, [
                'class' => Race::class,
                'choice_label' => 'race_name',
                'required' => false,
                'placeholder' => 'Toutes les races',
                'label' => 'Race'
            ])
            ->add('classe', EntityType::class, [
                'class' => Classe::class,
                'choice_label' => 'class_name',
                'multiple' => true,
                'expanded' => true,
                'required' => false,
            ])
        ;
    }
}
