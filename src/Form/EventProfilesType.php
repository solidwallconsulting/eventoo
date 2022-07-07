<?php

namespace App\Form;

use App\Entity\EventProfiles;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventProfilesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $lng = $options['lng'];

        $builder
            ->add('label', TextType::class, [
                'row_attr' => ['class' => 'form-group'],
                'required'=>true,
                'label' => $lng == 'en_EN' ? 'Profile name' : 'Label de profil' ,  
                'attr' => array('class' => 'form-control  mb-3 ', 'placeholder' => '' )
            ])
            ->add('tarification', ChoiceType::class, [
                'row_attr' => ['class' => 'form-group'],
                'choices'  => [
                    ($lng == 'en_EN' ? 'Free' : 'Gratuit')   => 0,
                    ($lng == 'en_EN' ? 'Payed' : 'Payant') => 1
                ],
                'required'=>true, 
                'label' => $lng == 'en_EN' ? 'Tarification' : 'Accès' , 
                'attr' => array('class' => 'form-control  mb-3 ', 'placeholder' => '' )
            ])
            ->add('price', TextType::class, [
                'row_attr' => ['class' => 'form-group'],
                'required'=>false,
                'label' => $lng == 'en_EN' ? 'Price' : 'Prix' , 
                'attr' => array('class' => 'form-control  mb-3 ',  'disabled' => 'disabled' )
            ])
            
            ->add('participantsNumber', IntegerType::class, [
                'row_attr' => ['class' => 'form-group'],
                'required'=>true, 
                'label' => $lng == 'en_EN' ? 'Available numbers' : 'Nombre maximum d’inscription' , 
                'attr' => array('class' => 'form-control  mb-3 ', 'placeholder' => '' )
            ])

            ->add('descreption', CKEditorType::class, [
                'config'=>array(
                    'toolbar'=>'full',
                    "colorButton_enableAutomatic"=>true
                ),
                'row_attr' => ['class' => 'form-group'],
                'required'=>true,
                'label' => $lng == 'en_EN' ? 'Description' : 'Déscription' , 
                'attr' => array('class' => 'form-control  mb-3 ', 'placeholder' => '' , 'rows'=>'4'  )
            ])


          

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EventProfiles::class,
            'lng'=>null
        ]);
    }
}
