<?php

namespace App\Form;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Randonnee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RandoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomRando')
            ->add('destination')
            ->add('description')
            ->add('categorieRando',ChoiceType::class, [
                'choices'  => [
                    'à pied' => 'pied',
                    'à vélo' => 'velo',
                    'au voiture' => 'voiture',
                ],
            ])
            ->add('dateRando')
            ->add('dureeRando');
            
           

            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Randonnee::class,
        ]);
    }
}
