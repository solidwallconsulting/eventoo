<?php

namespace App\Form;

use App\Entity\EventProfileFeildValue;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventProfileFeildValueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('value', TextType::class, [
                'required'=>true,
                'label' => 'Valeur( FR )',  
                'attr' => array('class' => 'form-control  mb-3 ', 'placeholder' => '' )
            ])
            ->add('valueEN', TextType::class, [
                'required'=>true,
                'label' => 'Valeur( EN )',  
                'attr' => array('class' => 'form-control  mb-3 ', 'placeholder' => '' )
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EventProfileFeildValue::class,
        ]);
    }
}
