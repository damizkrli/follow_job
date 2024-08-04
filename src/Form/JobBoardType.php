<?php

namespace App\Form;

use App\Entity\JobBoard;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JobBoardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du JobBoard',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Indeed, France Travail, HelloWork',
                ]
            ])
            ->add('link', UrlType::class, [
                'label' => 'Lien vers JobBoard',
                'required' => true,
                'attr' => [
                    'placeholder' => 'https://www.votre-jobboard-préféré.fr',
                ]
            ])
            ->add('profile', ChoiceType::class, [
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'label' => 'Profil à jour (CV, Disponibilité ... )',
                'required' => false,
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => JobBoard::class,
        ]);
    }
}
