<?php

namespace App\Form;

use App\Entity\Day;
use App\Entity\DayPicture;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DayType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id_day')
            ->add('template_day')
            ->add('title_day')
            ->add('date_day', null, [
                'widget' => 'single_text',
            ])
            ->add('dayPictures', EntityType::class, [
                'class' => DayPicture::class,
                'choice_label' => 'id',
                'multiple' => true,
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
