<?php

namespace App\Form;

use App\Entity\Application;
use App\Entity\Company;
use App\Entity\Contact;
use App\Entity\JobBoard;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplicationType extends AbstractType
{
    public const STATUT = [
        'Envoyée'    => 'Envoyée',
        'En attente' => 'En attente',
        'Refusée'    => 'Refusée',
        'Acceptée'   => 'Acceptée',
    ];

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('job_title')
            ->add('sent', null, [
                'widget' => 'single_text',
            ])
            ->add('response', null, [
                'widget' => 'single_text',
            ])
            ->add('link')
            ->add('note')
            ->add('company', EntityType::class, [
                'class'        => Company::class,
                'multiple' => true,
            ])
            ->add('contact', EntityType::class, [
                'class'        => Contact::class,
                'choice_label' => 'firstname',
            ])
            ->add('job_board', EntityType::class, [
                'class'        => JobBoard::class,
                'choice_label' => 'name',
            ])
            ->add('statut', ChoiceType::class, [
                'choices'     => self::STATUT,
                'placeholder' => 'Choisissez un statut',
                'label'       => "Statut",
                'required'    => false,
                'empty_data'  => 'Envoyée',
                'multiple'    => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Application::class,
        ]);
    }
}
