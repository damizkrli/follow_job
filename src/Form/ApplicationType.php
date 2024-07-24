<?php

namespace App\Form;

use App\Entity\Application;
use App\Entity\Company;
use App\Entity\Contact;
use App\Entity\JobBoard;
use App\Entity\Statut;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplicationType extends AbstractType
{
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
                'class' => Company::class,
                'choice_label' => 'id',
            ])
            ->add('contact', EntityType::class, [
                'class' => Contact::class,
                'choice_label' => 'id',
            ])
            ->add('job_board', EntityType::class, [
                'class' => JobBoard::class,
                'choice_label' => 'id',
            ])
            ->add('statut', EntityType::class, [
                'class' => Statut::class,
                'choice_label' => 'id',
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
