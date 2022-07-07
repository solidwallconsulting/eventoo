<?php

namespace App\Form;

use App\Entity\EventRooms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventRooms1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label')
            ->add('description')
            ->add('photoURL')
            ->add('photoAlt')
            ->add('maximumNumberOfParticipants')
            ->add('youtubeShare')
            ->add('event')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EventRooms::class,
        ]);
    }
}
