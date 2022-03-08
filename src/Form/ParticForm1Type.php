<?php

namespace App\Form;

use App\Entity\ParticForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParticForm1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('age')
            
            ->add('exp')
            ->add('so_domaine')
            ->add('so_ass')
            ->add('Numero')
            ->add('id_formation')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ParticForm::class,
        ]);
    }
}
