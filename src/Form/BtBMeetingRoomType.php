<?php

namespace App\Form;

use App\Entity\BtBMeetingRoom;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BtBMeetingRoomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $lng = $options['lng'];


        $builder
            
            
            ->add('meet', TextType::class, [ 
                'row_attr' => ['class' => 'form-group'],
                'label' => $lng == 'en_EN' ? 'Meet' : 'Nom de la rencontre', 
                'attr' => array('class' => 'form-control  mb-3 ', 'placeholder' => '' )
            ]) 
            
            ->add('theme', TextType::class, [ 
                'row_attr' => ['class' => 'form-group'],
                'label' => $lng == 'en_EN' ? 'Theme of the b2b meeting' : 'Thématique de la rencontre B2B', 
                'attr' => array('class' => 'form-control  mb-3 ', 'placeholder' => '' )
            ])
            
            ->add('state', ChoiceType::class, [ 
                'row_attr' => ['class' => 'form-group'],
                'label' => $lng == 'en_EN' ? 'state' : 'État', 
                'attr' => array('class' => 'form-control  mb-3 ', 'placeholder' => '' ),
                'choices'  => [
                    'active' => 0,
                    'inactive' => 1,
                ],
            ])
            ->add('maximumInvitationNumber', IntegerType::class, [ 
                'row_attr' => ['class' => 'form-group'],
                'label' => $lng == 'en_EN' ? "Maximum number of invitations" : "Nombre maximum de demandes envoyées", 
                'attr' => array('class' => 'form-control  mb-3 ', 'placeholder' => '' )
            ]) 
            ->add('nbrOfConfirmedMeetingPerMember', IntegerType::class, [ 
                'row_attr' => ['class' => 'form-group'],
                'label' => $lng == 'en_EN' ? "Maximum number of confirmed appointments" : "Nombre maximum de rendez vous confirmés", 
                'attr' => array('class' => 'form-control  mb-3 ', 'placeholder' => '' )
            ]) 
            


            ->add('access', ChoiceType::class, [
                'required'=>true,
                'label' => $lng == 'en_EN' ? 'Matching Networking Settings' : "Paramètres de mise en réseau correspondants ",  
                'row_attr' => ['class' => 'form-group','id'=>'accessebility_row',],
                'attr' => array(  "event-selector"=>"eventName" , 'class' => 'form-control  mb-3 '),
                'required'=>true,
                'choices'  => [
                    $lng == 'en_EN' ? 'Everyone can meet everyone' : "Tout le monde peut rencontrer tout le monde"=> 0,
                    $lng == 'en_EN' ? 'Limited by profile matching' : "Limité par la correspondance des profils"=> 1
                    
 

                    ],  
            ])


            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BtBMeetingRoom::class,
            'lng'=>null
        ]);
    }
}
