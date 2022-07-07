<?php

namespace App\Form;

use App\Entity\SubProfile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $lng = $options['lng'];
        $builder
            ->add('name', TextType::class, [ 
                'row_attr' => ['class' => 'form-group'],
                'label' => $lng == 'en_EN' ? 'Name' : 'Nom', 
                'attr' => array('class' => 'form-control  mb-3', 'placeholder' => '')
            ]) 
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SubProfile::class,
            'lng'=>null
        ]);
    }
}
