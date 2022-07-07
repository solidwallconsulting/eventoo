<?php

namespace App\Form;

use App\Entity\Events;
use App\Entity\EventsAccessibility;
use App\Entity\EventsAccessTypes;
use App\Entity\EventsDurations;
use App\Entity\EventsLanguages;
use App\Entity\EventTypes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimezoneType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

class EventsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $lng = $options['lng'];
        $secondStep = $options['secondStep'];


        if ($secondStep== false) {
            $builder
            ->add('name', TextType::class, [
                'required'=>true,
                'label' => $lng == 'en_EN' ? 'Event name' : "Nom de l'événement",  
                'row_attr' => ['class' => 'form-group'],
                'attr' => array( "event-selector"=>"eventName" , 'class' => 'form-control  mb-3 ', 'placeholder' =>   $lng == 'en_EN' ? "Typein event name" : "Saisissez le nom de l'événement" )
            ])
            ->add('type' , EntityType::class, [
                'required'=>true, 
                'label' => $lng == 'en_EN' ? 'Event Type' : "Accès à l'événement",   
                'class' => EventTypes::class, 
                'attr' => array('class' => 'form-control  mb-3'),
                'row_attr' => ['class' => 'form-group'],
            ])

            

            
            ->add('accessType', EntityType::class, [
                'required'=>true,
               
                'label' => $lng == 'en_EN' ? 'Event confidentiality' : "Accès à l'événement",    
                'class' => EventsAccessTypes::class, 
                'attr' => array('class' => 'form-control  mb-3'),
                'row_attr' => ['class' => 'form-group'],
            ]) 


            ->add('totalSubscribersNumber', IntegerType::class, [
                'required'=>true,
                'row_attr' => ['class' => 'form-group'],
                'label' => $lng == 'en_EN' ? 'Number of registrants' : "Nombre des inscrits total",  

                'attr' => array('class' => 'form-control  mb-3 ', "event-selector"=>"totalSubscribersNumber"   )
            ])
            ->add('eventsLengthInDays', IntegerType::class, [
                'row_attr' => ['class' => 'form-group'],
                'required'=>true,
                'label' => $lng == 'en_EN' ? 'number of days' : "Nombre de jours",  

                'attr' => array('class' => 'form-control  mb-3 ', "event-selector"=>"eventsLengthInDays" )
            ])

            ->add('startDate', DateTimeType::class, [
                'row_attr' => ['class' => 'form-group'],
                'required'=>true,
                'label' => $lng == 'en_EN' ? 'Start at' : "Début de l'événement",  
                'widget' => 'single_text',
                'attr' => array('class' => 'form-control  mb-3 ', "event-selector"=>"startDate" )
            ])
            ->add('endDate', DateTimeType::class, [
                'row_attr' => ['class' => 'form-group'],
                'required'=>true,
                'label' => $lng == 'en_EN' ? 'End at' : "Fin de l'événement",  
                'widget' => 'single_text',
                'attr' => array('class' => 'form-control  mb-3 ', "event-selector"=>"endDate" )
            ])

            ->add('typeZone', TimezoneType::class, [
                'row_attr' => ['class' => 'form-group'],
                'required'=>true,
                'label' => $lng == 'en_EN' ? 'Time zone by default' : "Fuseau horaire par défaut",   
                'attr' => array('class' => 'form-control  mb-3 ', "event-selector"=>"typeZone"),
                 
            ])

            ->add('location', TextType::class, [
                'row_attr' => ['class' => 'form-group'],
                'required'=>true,
                'label' => $lng == 'en_EN' ? 'Location' : "Lieu",   
                'attr' => array('class' => 'form-control  mb-3 ', "event-selector"=>"location")
            ])


            /** here */


            ->add('eventAccessibility', EntityType::class, [
                'required'=>true,
                
                'label' => $lng == 'en_EN' ? 'Available for' : "Accès : Public, Privé, inaccessible",  
                'class' => EventsAccessibility::class, 
                'attr' => array('class' => 'form-control  mb-3'),
                'row_attr' => ['class' => 'form-group'],
            ]) 
 

            

            ->add('eventLng', EntityType::class, [
                'required'=>true,
                
                'label' => $lng == 'en_EN' ? 'Language' : "Langue", 
                'class' => EventsLanguages::class, 
                'attr' => array('class' => 'form-control  mb-3'),
                'row_attr' => ['class' => 'form-group'],
                 
            ])
            ->add('willBeAvailableForNMonths', EntityType::class, [
                'required'=>true,
                'placeholder' => $lng == 'en_EN' ? 'Duration' : "Durée d’affichage de l'événement après concrétisation",
                'label' => $lng == 'en_EN' ? 'Duration( in months )' : "Durée ( en mois )",
                'class' => EventsDurations::class, 
                'attr' => array('class' => 'form-control  mb-3'),
                'row_attr' => ['class' => 'form-group'],
                ]) ;



        } else {
            $builder 
           
            

            ->add('description', CKEditorType::class, [
                'config'=>array(
                    'toolbar'=>'full',
                    "colorButton_enableAutomatic"=>true
                ),
                'required'=>true,
                'label' => $lng == 'en_EN' ? 'About event' : "Informations sur l'événement",  
                'row_attr' => ['class' => 'form-group'],
                'attr' => array( "event-selector"=>"eventName" , 'class' => 'form-control  mb-3 ')
            ])
            ->add('photoURL', FileType::class, [
                'required'=>false,
                //'label' => $lng == 'en_EN' ? 'Event image' : "Image de l'événement",  
                'label' => " ", 
                "mapped"=>false, 
                
                'row_attr' => ['class' => 'form-group d-none'],
                'attr' => array(  "event-selector"=>"eventName" , 'class' => 'form-control' )
            ])


            

            ->add('themeColor',  ColorType::class, [
                'row_attr' => ['class' => 'form-group'],
                'required'=>true,
                'label' => $lng == 'en_EN' ? 'Theme color' : "Couleur du thème",   
                'attr' => array('class' => 'form-control  mb-3 ', "event-selector"=>"location")
            ])
            ->add('textThemeColor',  ColorType::class, [
                'row_attr' => ['class' => 'form-group'],
                'required'=>true,
                'label' => $lng == 'en_EN' ? 'Theme text color' : "Couleur du texte du thème",   
                'attr' => array('class' => 'form-control  mb-3 ', "event-selector"=>"location")
            ])
            ->add('numberOfSessionTextColor',  ColorType::class, [
                'row_attr' => ['class' => 'form-group'],
                'required'=>true,
                'label' => $lng == 'en_EN' ? 'Number of session text color' : "Nombre de session couleur du texte",   
                'attr' => array('class' => 'form-control  mb-3 ', "event-selector"=>"location")
            ])
            ->add('numberOfSessionColor',  ColorType::class, [
                'row_attr' => ['class' => 'form-group'],
                'required'=>true,
                'label' => $lng == 'en_EN' ? 'Number of sessions color' : "Nombre de sessions couleur",   
                'attr' => array('class' => 'form-control  mb-3 ', "event-selector"=>"location")
            ])
            ->add('chatLinkColor',  ColorType::class, [
                'row_attr' => ['class' => 'form-group'],
                'required'=>true,
                'label' => $lng == 'en_EN' ? 'Chat link color' : "Couleur du lien de chat",   
                'attr' => array('class' => 'form-control  mb-3 ', "event-selector"=>"location")
            ])
            ->add('ExpoTabColor',  ColorType::class, [
                'row_attr' => ['class' => 'form-group'],
                'required'=>true,
                'label' => $lng == 'en_EN' ? 'Expo tab color' : "Couleur de l'onglet Expo",   
                'attr' => array('class' => 'form-control  mb-3 ', "event-selector"=>"location")
            ])
            ->add('agendaMenuColor',  ColorType::class, [
                'row_attr' => ['class' => 'form-group'],
                'required'=>true,
                'label' => $lng == 'en_EN' ? 'Agenda menu color' : "Couleur du menu agenda",   
                'attr' => array('class' => 'form-control  mb-3 ', "event-selector"=>"location")
            ])
            ->add('tabFontColor',  ColorType::class, [
                'row_attr' => ['class' => 'form-group'],
                'required'=>true,
                'label' => $lng == 'en_EN' ? 'Tab font color' : "Couleur de la police des onglets",   
                'attr' => array('class' => 'form-control  mb-3 ', "event-selector"=>"location")
            ])
            ->add('tabColor',  ColorType::class, [
                'row_attr' => ['class' => 'form-group'],
                'required'=>true,
                'label' => $lng == 'en_EN' ? 'Tab color' : "Couleur des onglets",   
                'attr' => array('class' => 'form-control  mb-3 ', "event-selector"=>"location")
            ])
            



 
  

            



            ->add('logoURL', FileType::class, [
                'required'=>false,
                'label' => "  ",   
                "mapped"=>false, 
                
                'row_attr' => ['class' => 'form-group d-none'],
                'attr' => array(  "event-selector"=>"eventLogo" , 'class' => 'form-control d-none' )
            ])


            ->add('logoURL', FileType::class, [
                'required'=>false,
                'label' => "  ",   
                "mapped"=>false, 
                
                'row_attr' => ['class' => 'form-group d-none'],
                'attr' => array(  "event-selector"=>"eventLogo" , 'class' => 'form-control d-none' )
            ])
            
            
            ->add('logoAlt', TextType::class, [
                'required'=>false,
                'label' => 'Logo Alt',  
                'row_attr' => ['class' => 'form-group'],
                'attr' => array(  "event-selector"=>"eventName" , 'class' => 'form-control  mb-3 ', )
            ])
            
           
            ->add('streamingPlatform', ChoiceType::class, [
                'required'=>true,
                'label' => $lng == 'en_EN' ? 'Streaming platform' : "Plateforme de streaming",  
                'row_attr' => ['class' => 'form-group'],
                'attr' => array(  "event-selector"=>"eventName" , 'class' => 'form-control  mb-3 '),
                'required'=>true,
                'choices'  => [
                    'YouTube'=>'1',
                    'Vimeo'=>'2',
                    'Iframe'=>'3',
                    ],
                
                 
            ])
 
            ->add('steamingLINK', TextType::class, [
                'required'=>true,
                'label' => $lng == 'en_EN' ? 'Streaming Link' : "Lien de vidéo",  
                'row_attr' => ['class' => 'form-group'],
                'attr' => array(  "event-selector"=>"eventName" , 'class' => 'form-control  mb-3 ', )
            ]);
        
        }
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Events::class,
            'lng'=>null,
            'secondStep'=>false
        ]);
    }
}
