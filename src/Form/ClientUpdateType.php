<?php

namespace App\Form;

use App\Models\ClientModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $lng = $options['lng'];


        $builder  
            ->add('firstname', TextType::class, [
                  
                'label' => $lng == 'en_EN' ? 'First name' : 'Prénom', 
                'translation_domain' => 'messages', 
                'attr' => array('class' => 'form-control  mb-3 ', 'placeholder' => '' )
            ])
            ->add('lastname', TextType::class, [ 
                'label' => $lng == 'en_EN' ? 'Last name' : 'Nom', 
                'attr' => array('class' => 'form-control  mb-3 ', 'placeholder' => '' )
            ])
            ->add('clientName', TextType::class, [ 
                'label' => $lng == 'en_EN' ? 'Client name' : 'Nom du client', 
                'attr' => array('class' => 'form-control  mb-3 ', 'placeholder' => '' )
            ])
            ->add('civility', ChoiceType::class, [ 
                'label' => $lng == 'en_EN' ? 'Civility' : 'Civilié', 
                'attr' => array('class' => 'form-control  mb-3 ', 'placeholder' => '' ),
                'choices'  => [
                    'Mr' => 'Mr',
                    'Mme' => "Mme",
                ],
            ])
            ->add('function', TextType::class, [ 
                'label' => $lng == 'en_EN' ? 'Function' : 'Fonction', 
                'attr' => array('class' => 'form-control  mb-3 ', 'placeholder' => '' )
            ])
            ->add('phone', TelType::class, [ 
                'label' => $lng == 'en_EN' ? 'Phone' : 'Télephone', 
                'attr' => array('class' => 'form-control  mb-3  mobile-number', 'placeholder' => '' )
            ])

            ->add('countryIndex', TelType::class, [
                'row_attr' => array(
                    'class' => 'hidden-form-control'
                ),

                'label' => ' ',
                'attr' => array('class' => 'form-control  mb-3  ', 'placeholder' => '' )
            ])
            
            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ClientModel::class,
            'lng'=>null
        ]);
    }
}
