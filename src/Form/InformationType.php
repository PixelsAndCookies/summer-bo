<?php

namespace App\Form;

use App\Entity\Information;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class InformationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '50',

                ],
                'label' => 'Nom',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50])]
            ])
            ->add('text',TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '50',

                ],
                'label' => 'Texte (sous l\'icône)',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50])],
                'required' => false
                    
            ])
            ->add('link',TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '50',

                ],
                'label' => 'Lien',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50])],
                'required' => false
            ])
            ->add('icon',TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Icône',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50])]
            ])
            ->add('info',TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '50',

                ],
                'label' => 'Bulle info (au survol)',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50])],
                'required' => false
            ])
            ->add('position',IntegerType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Position',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ]
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'En ligne' => true,
                    'Hors ligne' => false
                ],
                'choice_attr' => [
                    'En ligne' => ['class' => 'btn-check'],
                    'Hors ligne' => ['class' => 'btn-check'],
                ],
                'expanded' => true,
                'attr' => [
                    'class' => 'btn-group'
                ],
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'label' => 'Statut',
                'required' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Information::class,
        ]);
    }
}
