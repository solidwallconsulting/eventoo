<?php

namespace App\Form;

use App\Entity\StandVideos;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StandVideosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $lng = $options['lng'];
        $builder
            ->add('lien', UrlType::class, [ 
                'row_attr' => ['class' => 'form-group'],
                'label' => $lng == 'en_EN' ? 'Lien' : 'Link', 
                'attr' => array('class' => 'form-control  mb-3', 'placeholder' => '')
            ])
            ->add('name', TextType::class, [ 
                'row_attr' => ['class' => 'form-group'],
                'label' => $lng == 'en_EN' ? 'Name' : 'Nom', 
                'attr' => array('class' => 'form-control  mb-3', 'placeholder' => '')
            ])
            ->add('description', CKEditorType::class, [ 
                'row_attr' => ['class' => 'form-group'],
                'label' => $lng == 'en_EN' ? 'Description' : 'Description', 
                'attr' => array('class' => 'form-control  mb-3', 'placeholder' => '')
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => StandVideos::class,
            'lng'=>null
        ]);
    }
}
