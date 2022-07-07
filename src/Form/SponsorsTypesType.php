<?php

namespace App\Form;

use App\Entity\SponsorsTypes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SponsorsTypesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $lng = $options['lng'];
        $builder
            ->add('name', TextType::class, [ 
                'label' => $lng == 'en_EN' ? 'Name' : 'Nom', 
                'attr' => array('class' => 'form-control  mb-3', 'placeholder' => '')
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SponsorsTypes::class,
            'lng'=>null
        ]);
    }
}
