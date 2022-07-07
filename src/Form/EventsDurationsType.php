<?php

namespace App\Form;

use App\Entity\EventsDurations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventsDurationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $lng = $options['lng'];

        $builder
            ->add('duration', IntegerType::class, [
                'required'=>true,
                'label' => $lng == 'en_EN' ? 'Duration( in months )' : "Durée( en mois )",  
                'row_attr' => ['class' => 'form-group'],
                'attr' => array( "event-selector"=>"eventName" , 'class' => 'form-control  mb-3 '  )
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EventsDurations::class,
            'lng'=>null,
        ]);
    }
}
