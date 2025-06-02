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
                'widget' => 'single_text', // format HTML5 date picker
                'label' => 'Date d\'envoi',
            ])
            ->add('company', SearchType::class, [
                'required' => false,
                'label' => 'Nom de l\'entreprise',
                'attr' => [
                    'placeholder' => 'Entreprise',
                ],
            ])
            ->add('jobboard', SearchType::class, [
                'required' => false,
                'label' => 'Job Board',
                'attr' => [
                    'placeholder' => 'Job Board',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
