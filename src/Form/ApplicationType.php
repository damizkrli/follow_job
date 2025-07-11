<?php

namespace App\Form;

use App\Entity\Application;
use App\Entity\Jobboard;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Status;

class ApplicationType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('status', EntityType::class, [
                'class' => Status::class,
                'choice_label' => 'name',
                'label' => "Statut",
                'placeholder' => "Choisissez un statut",
                'required' => true,
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('job_title', TextType::class, [
                'label'    => 'Intitulé du poste',
                'required' => true,
                'attr'     => [
                    'placeholder' => 'Développeur Web Fullstack'
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ]
            ])
            ->add('city', TextType::class, [
                'label'    => 'Ville',
                'required' => true,
                'attr'     => [
                    'placeholder' => 'Bordeaux, Toulouse ...'
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ]
            ])
            ->add('response', DateType::class, [
                'widget'   => 'single_text',
                'label'    => 'Date de réponse',
                'required' => false,
                'row_attr' => [
                    'class' => 'form-floating',
                ]
            ])
            ->add('link', UrlType::class, [
                'label'    => 'Lien vers l\'annonce',
                'required' => true,
                'row_attr' => [
                    'class' => 'form-floating',
                ],
                'attr'     => [
                    'placeholder' => 'Lien vers l\'annonce',
                ]
            ])
            ->add('company', TextType::class, [
                'label' => 'Entreprise',
                'required' => true,
                'attr'     => [
                    'placeholder' => 'Google, Microsoft ...'
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ]
            ])
            ->add('jobboard', EntityType::class, [
                'class' => Jobboard::class,
                'choice_label' => 'name',
                'label' => "Plateforme",
                'placeholder' => "Choisissez une plateforme",
                'required' => false,
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('note', TextareaType::class, [
                    'required' => false,
                    'label' => 'Note',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Application::class,
        ]);
    }
}
