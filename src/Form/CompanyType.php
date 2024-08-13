<?php

namespace App\Form;

use App\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de l\'entreprise',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Nom de l\'entreprise',
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ]
            ])
            ->add('activity', TextType::class, [
                'label' => 'Secteur d\'activité',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Agroalimentaire, Banque/Assurance, ...'
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse',
                'required' => false,
                'attr' => [
                    'placeholder' => '10 rue de l\'Église',
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('postalCode', IntegerType::class, [
                'label' => 'Code postal',
                'required' => false,
                'attr' => [
                    'placeholder' => '75000'
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Paris',
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
            'validation_groups' => ['Default', 'unique_email'],
        ]);
    }
}
