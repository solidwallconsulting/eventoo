<?php

namespace App\Form;

use App\Entity\EventProfiles;
use App\Entity\Profile;
use App\Entity\StandConfigurations;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StandConfigurationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $lng = $options['lng'];
        $profiles = $options['profiles'];

        $builder
            ->add('maximumNumberOfProducts', IntegerType::class, [ 
                'row_attr' => ['class' => 'form-group'],
                'label' => $lng == 'en_EN' ? 'Number of products' : 'Nombre des produits', 
                'attr' => array('class' => 'form-control  mb-3', 'placeholder' => '')
            ])
            ->add('maximumNumberOfCatalogues', IntegerType::class, [ 
                'row_attr' => ['class' => 'form-group'],
                'label' => $lng == 'en_EN' ? 'Number of catalogs' : 'Nombre des catalogues', 
                'attr' => array('class' => 'form-control  mb-3', 'placeholder' => '')
            ])
            ->add('maximumNumberOfVideos', IntegerType::class, [ 
                'row_attr' => ['class' => 'form-group'],
                'label' => $lng == 'en_EN' ? 'Number of Videos' : 'Nombre des Vidéos', 
                'attr' => array('class' => 'form-control  mb-3', 'placeholder' => '')
            ])
            ->add('profile', EntityType::class, [
                'required'=>true,
                'placeholder'=>$lng == 'en_EN' ? 'please choose a value' : "veuillez choisir une valeur",
                'label' => $lng == 'en_EN' ? 'Profile' : "Profil",  
                'class' => EventProfiles::class, 
                'attr' => array('class' => 'form-control  mb-3', 'placeholder' => ''),
                'row_attr' => ['class' => 'form-group'],
                'choices'=>$profiles
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => StandConfigurations::class,
            'lng'=>null,
            'profiles'=>null
        ]);
    }
}
