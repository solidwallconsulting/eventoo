<?php

namespace App\Form;

use App\Entity\EventsAccessibility;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventsAccessibilityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $lng = $options['lng'];

        $builder
            ->add('name', TextType::class, [
                'required'=>true,
                'label' => $lng == 'en_EN' ? 'name' : "Nom",  
                'row_attr' => ['class' => 'form-group'],
                'attr' => array( "event-selector"=>"eventName" , 'class' => 'form-control  mb-3 ', 'placeholder' =>   $lng == 'en_EN' ? "Typein event name" : "Saisissez le nom de l'événement" )
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EventsAccessibility::class,
            'lng'=>null,
        ]);
    }
}
