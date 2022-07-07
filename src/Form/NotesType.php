<?php

namespace App\Form;

use App\Entity\Notes;
use App\Entity\NotesCategories;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NotesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $lng = $options['lng'];

        $builder
            
            ->add('category', EntityType::class, [
                
                'class' => NotesCategories::class,
                'label' => $lng == 'en_EN' ? 'Category' : 'Types de notes', 
                'required' => true,
                'placeholder' =>  $lng == 'en_EN' ? 'Please choose a value' : 'Veuillez choisir le type de note',

                'attr' => array('class' => 'form-control form-control-lg form-control-solid  mb-3')
            ])
            ->add('content', TextareaType::class, [ 
                'label' => $lng == 'en_EN' ? 'Note' : 'Note', 
                'attr' => array('class' => 'form-control  mb-3', 'placeholder' => '')
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Notes::class,
            'lng'=>null
        ]);
    }
}
