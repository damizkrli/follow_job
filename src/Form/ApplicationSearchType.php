<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplicationSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('jobTitle', SearchType::class, [
                'required' => false,
                'label' => 'Intitulé du Poste',
                'attr' => [
                    'placeholder' => 'Développeur Java, Full-Stack, ...'
                ]
            ])
            ->add('sent', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('company', SearchType::class, [
                'required' => false,
                'label' => 'Nom de l\'entreprise',
                'attr' => [
                    'placeholder' => 'Google, Apple, ...',
                ],
            ])
            ->add('jobboard', SearchType::class, [
                'required' => false,
                'label' => 'Job Board',
                'attr' => [
                    'placeholder' => 'Linkedin, Indeed, ...',
                ],
            ])
            ->add('city', SearchType::class, [
                'required' => false,
                'label' => 'Ville',
                'attr' => [
                    'placeholder' => 'Bordeaux, Paris, ...'
                ]
            ])            
        ;
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
