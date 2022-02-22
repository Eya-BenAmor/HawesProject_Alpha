<?php

namespace App\Form;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
            ->add('dureeRando')
            ->add('prix')
            ->add('image', FileType::class, [
                'label' => 'upload image',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the  file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in th e associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/jpg',
                            'image/png',
                            'image/jpeg',
                        ],
                        
                    ])
                ],
            ]) ;
            
           

            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Randonnee::class,
        ]);
    }
}
