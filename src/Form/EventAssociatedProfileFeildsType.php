<?php

namespace App\Form;

use App\Entity\EventAssociatedProfileFeilds;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventAssociatedProfileFeildsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('profile')
            ->add('field')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EventAssociatedProfileFeilds::class,
        ]);
    }
}
