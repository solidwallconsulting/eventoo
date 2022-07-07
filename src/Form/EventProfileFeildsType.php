<?php

namespace App\Form;

use App\Entity\EventProfileFeilds;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventProfileFeildsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $isEditing = $options['isEditing'];

        $builder
            ->add('labelFr', TextType::class, [
                'required'=>true,
                'label' => 'Label FR',  
                'attr' => array('class' => 'form-control  mb-3 ', 'placeholder' => '' )
            ])
            ->add('labelEN', TextType::class, [
                'required'=>true,
                'label' => 'Label EN',  
                'attr' => array('class' => 'form-control  mb-3 ', 'placeholder' => '' )
            ])
            
            
            ->add('required')
            ->add('primaryFeild');
            
            $builder->add('lingneOrder', TextType::class, [
                'required'=>true,
                'label' => 'Order',  
                'attr' => array('class' => 'form-control  mb-3 ', 'placeholder' => '' )
            ]);
            
            
            if( $isEditing == true ){
                
                
            }

            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EventProfileFeilds::class,
            'isEditing'=>false
        ]);
    }
}
