<?php

namespace App\Form;

use App\Entity\StandProduct;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StandProductType extends AbstractType
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
            
            ->add('descreption', CKEditorType::class, [ 
                'row_attr' => ['class' => 'form-group'],
                'label' => $lng == 'en_EN' ? 'Description' : 'Description', 
                'attr' => array('class' => 'form-control  mb-3', 'placeholder' => '')
            ])
            ->add('photoURL', FileType::class, [ 
                'row_attr' => ['class' => 'form-group'],
                'mapped'=>false,
                'label' => $lng == 'en_EN' ? 'Image' : 'Photo', 
                'attr' => array('class' => 'form-control  mb-3', 'placeholder' => '')
            ])
             
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => StandProduct::class,
            'lng'=>null
        ]);
    }
}
