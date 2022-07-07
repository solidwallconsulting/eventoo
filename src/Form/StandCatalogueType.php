<?php

namespace App\Form;

use App\Entity\StandCatalogue;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StandCatalogueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $lng = $options['lng'];

        $builder
            ->add('catalogeName', TextType::class, [ 
                'label' => $lng == 'en_EN' ? 'Name' : 'Nom', 
                'attr' => array('class' => 'form-control  mb-3', 'placeholder' => '')
            ])
            ->add('catalogePDFURL', FileType::class, [ 
                'mapped'=>false,
                'label' => $lng == 'en_EN' ? 'PDF' : 'PDF', 
                'attr' => array('class' => 'form-control  mb-3', 'placeholder' => '')
            ])
            
 
             
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => StandCatalogue::class,
            'lng'=>null
        ]);
    }
}
