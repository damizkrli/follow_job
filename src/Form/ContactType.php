<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'required' => true,
                'attr' => [
                    'placeholder' => 'John',
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Doe',
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'required' => true,
                'attr' => [
                    'placeholder' => 'john.doe@example.com',
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ]
            ])
            ->add('phone', TextType::class, [
                'label' => 'Téléphone',
                'required' => true,
                'attr' => [
                    'placeholder' => '0742679131',
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('social', UrlType::class, [
                'label' => 'Profil Linkedin',
                'required' => true,
                'attr' => [
                    'placeholder' => 'https://www.linkedIn.com',
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
