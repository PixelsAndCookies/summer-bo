<?php

namespace App\Form;

use ContentType;
use App\Entity\Day;
use App\Entity\Picture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class DayType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('title_day', TextType::class, [
                'label' => 'Titre du jour'
            ])
            ->add('contents', CollectionType::class, [
                'entry_type' => ContentType::class,
                'by_reference' => false,
                'entry_options' => ['label' => false]
            ])
            ->add('dayPictures', EntityType::class, [
                'class' => Picture::class,
                'choice_label' => 'filename',  // Le champ que tu veux afficher (par exemple le nom de fichier)
                'multiple' => true,            // Sélection multiple
                'expanded' => true,           // Liste déroulante (true pour des cases à cocher)
                'by_reference' => false,
            ])
            ->add('pictureOrder', HiddenType::class, [
                'mapped' => false, // Champ non mappé à une propriété d'entité pour stocker l'ordre des images
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Day::class,
        ]);
    }
}
