<?php

namespace App\Form;

use App\Entity\EventProfiles;
use App\Entity\EventStandMesures;
use App\Entity\EventStands;
use App\Entity\Participant;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

 

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormEvents;



class EventStandsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $participants = $options['participants'];
        $lng = $options['lng'];
        $tags = $options['tags'];
        

        $builder

            ->add('Participant', EntityType::class, [
                'choice_label'=>'standName',
                'required'=>true,
                'placeholder'=>$lng == 'en_EN' ? 'please choose a value' : "veuillez choisir une valeur",
                'label' => $lng == 'en_EN' ? 'Participant' : "Participant",  
                'class' => Participant::class, 
                'attr' => array('class' => 'form-control  mb-3', 'placeholder' => ''),
                'row_attr' => ['class' => 'form-group'],
                'choices'=>$participants
            
            ])

            ->add('providername', TextType::class, [
                'required'=>true,
                'label' => $lng == 'en_EN' ? 'Provider name' : "Nom du fournisseur",  
                'row_attr' => ['class' => 'form-group'],
                'attr' => array( "event-selector"=>"eventName" , 'class' => 'form-control  mb-3 ' )
            ])
            ->add('providerEmail', TextType::class, [
                'required'=>true,
                'label' => $lng == 'en_EN' ? 'Provider email' : "Email du fournisseur",  
                'row_attr' => ['class' => 'form-group'],
                'attr' => array( "event-selector"=>"eventName" , 'class' => 'form-control  mb-3 ' )
            ])
            ->add('providerTitle', TextType::class, [
                'required'=>true,
                'label' => $lng == 'en_EN' ? 'Provider title' : "Titre du fournisseur",  
                'row_attr' => ['class' => 'form-group'],
                'attr' => array( "event-selector"=>"eventName" , 'class' => 'form-control  mb-3 ' )
            ])
            ->add('description', CKEditorType::class, [
               
                'label' => $lng == 'en_EN' ? 'Description' : "Description",  
                'row_attr' => ['class' => 'form-group'],
                'attr' => array( "event-selector"=>"eventName" , 'class' => 'form-control  mb-3 ' )
            ])
            ->add('tags', ChoiceType::class, [ 
                'required'=>false,
                'choices' => $tags,
                'multiple'=>true ,
                'label' => $lng == 'en_EN' ? 'Tags' : 'Tags' , 
                'row_attr' => ['class' => 'form-group'],
                'attr' => array(  "event-selector"=>"roomKeyWords" , 'class' => 'form-control  mb-3 ' )
            ])
           
            
            
            ->add('mesure', EntityType::class, [
                'required'=>true,
                'placeholder'=>$lng == 'en_EN' ? 'please choose a value' : "Superficie de stand",
                'label' => $lng == 'en_EN' ? 'Measure' : "Mesure",  
                'class' => EventStandMesures::class, 
                'attr' => array('class' => 'form-control  mb-3', 'placeholder' => ''),
                'row_attr' => ['class' => 'form-group'],
               
            ])

            ->add('location', TextType::class, [
                'required'=>true,
                'label' => $lng == 'en_EN' ? 'Location' : "Emplacement",  
                'row_attr' => ['class' => 'form-group'],
                'attr' => array( "event-selector"=>"eventName" , 'class' => 'form-control  mb-3 ' )
            ])

            ->add('numberID', IntegerType::class, [
                'required'=>true,
                'label' => $lng == 'en_EN' ? 'Booth number' : "Numéro du stand",  
                'row_attr' => ['class' => 'form-group'],
                'attr' => array( "event-selector"=>"eventName" , 'class' => 'form-control  mb-3 ' )
            ])

            


            


            ->add('url', UrlType::class, [
                'required'=>false,
                'label' => $lng == 'en_EN' ? 'Web site' : "Site web",  
                'row_attr' => ['class' => 'form-group'],
                'attr' => array( "event-selector"=>"eventName" , 'class' => 'form-control  mb-3 ' )
            ])
            ->add('linkedIn', TextType::class, [
                'required'=>false,
                'label' => $lng == 'en_EN' ? 'LinkedIn' : "LinkedIn",  
                'row_attr' => ['class' => 'form-group'],
                'attr' => array( "event-selector"=>"eventName" , 'class' => 'form-control  mb-3 ' )
            ])
            ->add('instagram', TextType::class, [
                'required'=>false,
                'label' => $lng == 'en_EN' ? 'Instagram' : "Instagram",  
                'row_attr' => ['class' => 'form-group'],
                'attr' => array( "event-selector"=>"eventName" , 'class' => 'form-control  mb-3 ' )
            ])
            ->add('twitter', TextType::class, [
                'required'=>false,
                'label' => $lng == 'en_EN' ? 'Twitter' : "Twitter",  
                'row_attr' => ['class' => 'form-group'],
                'attr' => array( "event-selector"=>"eventName" , 'class' => 'form-control  mb-3 ' )
            ])
            ->add('facebook', TextType::class, [
                'required'=>false,
                'label' => $lng == 'en_EN' ? 'Facebook' : "Facebook",  
                'row_attr' => ['class' => 'form-group'],
                'attr' => array( "event-selector"=>"eventName" , 'class' => 'form-control  mb-3 ' )
            ])

            ->add('canEditParams', CheckboxType::class, [
                'required'=>false,
                'label' => $lng == 'en_EN' ? 'Can edit stand parameters ?' : "Peut modifier les paramètres du stand ?",  
                'row_attr' => ['class' => 'form-group'],
                'attr' => array( "event-selector"=>"eventName" , 'class' => 'd-block  mb-3 ' )
            ])
             
        ;


        $formModifier = function (FormInterface $form, $choices) {
             

            $form ->add('tags', ChoiceType::class, [ 
                'choices' =>$choices,
                'multiple'=>true ,
                'label' => 'Tags' , 
                'row_attr' => ['class' => 'form-group'],
                'attr' => array(  "event-selector"=>"roomKeyWords" , 'class' => 'form-control  mb-3 ' )
            ]);
        };



        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                // this would be your entity 
                $data = $event->getData();  
                $tmp = [];
                

                if (  isset($data['tags']) ) {
                    foreach ($data['tags'] as $key => $value) {
                        $tmp[$value]=$value;
                    }
                }

                $formModifier($event->getForm(), $tmp );
            }
        );


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EventStands::class,
            'participants'=>[],
            'lng'=>null,
            'tags' => []
        ]);
    }
}
