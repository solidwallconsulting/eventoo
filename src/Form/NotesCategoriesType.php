<?php

namespace App\Form;

use App\Entity\NotesCategories;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NotesCategoriesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $lng = $options['lng'];


        $builder
            ->add('name', TextType::class, [ 
                'label' => $lng == 'en_EN' ? 'Name' : 'Nom', 
                'row_attr' => ['class' => 'form-group'],
                'attr' => array('class' => 'form-control  mb-3', 'placeholder' => '')
            ])
            ->add('colorCode', ColorType::class, [ 
                'label' => $lng == 'en_EN' ? 'Color code' : 'Code couleur', 
                'row_attr' => ['class' => 'form-group'],
                'attr' => array('class' => 'form-control  mb-3', 'placeholder' => '')
            ])
        
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => NotesCategories::class,
            'lng'=>null
        ]);
    }
}
