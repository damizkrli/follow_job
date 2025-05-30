<?php

namespace App\Form;

use App\Entity\Application;
use App\Entity\Company;
use App\Entity\Contact;
use App\Entity\JobBoard;
use App\Repository\CompanyRepository;
use App\Repository\ContactRepository;
use App\Repository\JobBoardRepository;
use Doctrine\DBAL\Types\TextType as TypesTextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplicationType extends AbstractType
{
    private const STATUT = [
        'Envoyée'    => 'Envoyée',
        'En attente' => 'En attente',
        'Refusée'    => 'Refusée',
        'Acceptée'   => 'Acceptée',
    ];

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('statut', ChoiceType::class, [
                'choices'     => self::STATUT,
                'label'       => "Statut",
                'placeholder' => "Choisissez un statut",
                'required'    => false,
                'row_attr'    => [
                    'class' => 'form-floating',
                ]
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
            ->add('sent', DateType::class, [
                'widget'   => 'single_text',
                'label'    => 'Date d\'envoi',
                'required' => true,
                'row_attr' => [
                    'class' => 'form-floating',
                ],
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
            ->add('jobboard', TextType::class, [
                'label' => 'Plateforme',
                'required' => false,
                'attr'     => [
                    'placeholder' => 'Plateformes'
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ]
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
