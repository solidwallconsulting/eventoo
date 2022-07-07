<?php

namespace App\Form;

use App\Entity\EventStandMesures;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventStandMesuresType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $lng = $options['lng'];
        $builder
            ->add('meusure', TextType::class, [
                'required'=>true,
                'label' => $lng == 'en_EN' ? 'Measure' : "Superficie de stand",  
                'row_attr' => ['class' => 'form-group'],
                'attr' => array( "event-selector"=>"eventName" , 'class' => 'form-control  mb-3 ' )
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EventStandMesures::class,
            'lng'=> null
        ]);
    }
}
