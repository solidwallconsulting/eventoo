<?php

namespace App\Form;

use App\Entity\Sponsors;
use App\Entity\SponsorsTypes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SponsorsType extends AbstractType
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
            ->add('website', TextType::class, [ 
                'label' => $lng == 'en_EN' ? 'Web site' : 'Site web', 
                'row_attr' => ['class' => 'form-group'],
                'attr' => array('class' => 'form-control  mb-3', 'placeholder' => '')
            ])
            ->add('logoURL', FileType::class, [
                'required'=>false,
                'label' => $lng == 'en_EN' ? 'Logo' : "Logo",   
                "mapped"=>false,  
                'row_attr' => ['class' => 'form-group'],
                'attr' => array(  "event-selector"=>"eventName" , 'class' => 'form-control image-picker-resizer' )
            ])
            ->add('type', EntityType::class, [
                'label' => $lng == 'en_EN' ? 'Sponsor type' : "Type de sponsor",  
                'class' => SponsorsTypes::class, 
                'attr' => array('class' => 'form-control  mb-3', 'placeholder' => ''),
                'row_attr' => ['class' => 'form-group'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sponsors::class,
            'lng'=>null
        ]);
    }
}
