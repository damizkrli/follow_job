<?php

namespace App\Form;

use App\Entity\Application;
use App\Entity\Company;
use App\Entity\Contact;
use App\Entity\JobBoard;
use App\Repository\CompanyRepository;
use App\Repository\ContactRepository;
use App\Repository\JobBoardRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
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
            ->add('note', TextareaType::class, [
                'label'    => false,
                'required' => false,
                'attr'     => [
                    'placeholder' => 'À propos de l\'entreprise...',
                    'rows'        => '20',
                    'cols'        => '20',
                ],
            ])
            ->add('company', EntityType::class, [
                'class'         => Company::class,
                'placeholder'   => 'Sélectionner une entreprise',
                'choice_label'  => 'name',
                'row_attr'      => [
                    'class' => 'form-floating',
                ],
                'query_builder' => function (CompanyRepository $companyRepository) {
                    return $companyRepository
                        ->createQueryBuilder('company')
                        ->orderBy('company.name', 'ASC');
                },
                'required'      => false,
            ])
            ->add('contact', EntityType::class, [
                'class'         => Contact::class,
                'placeholder'   => 'Sélectionner un contact',
                'choice_label'  => 'firstname',
                'row_attr'      => [
                    'class' => 'form-floating',
                ],
                'query_builder' => function (ContactRepository $contactRepository) {
                    return $contactRepository
                        ->createQueryBuilder('contact')
                        ->orderBy('contact.firstname', 'ASC');
                },
                'required'      => false,
            ])
            ->add('job_board', EntityType::class, [
                'class'         => JobBoard::class,
                'placeholder'   => 'Sélectionner un Jobboard',
                'choice_label'  => 'name',
                'row_attr'      => [
                    'class' => 'form-floating',
                ],
                'query_builder' => function (JobBoardRepository $jobBoardRepository) {
                    return $jobBoardRepository
                        ->createQueryBuilder('jobboard')
                        ->orderBy('jobboard.name', 'ASC');
                },
                'required'      => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Application::class,
        ]);
    }
}
