<?php

namespace App\Form;

use App\Entity\Description;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\TextEditorType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class DescriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '50',

                ],
                'label' => 'Titre de la section (optionnel)',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50])
                ],
                'required' => false
            ])
            ->add('content', CKEditorType::class, [
                'config' => [
                    'height' => 500
                ],
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'rows' => '20'
                ],
                'label' => 'Texte',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\NotBlank()
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Description::class,
        ]);
    }
}
