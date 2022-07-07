<?php

namespace App\Form;

use App\Entity\RoomProgramm;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimezoneType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormEvents;

class RoomProgrammType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $lng = $options['lng'];
        $participants = $options['participants'];
        $sponsors = $options['sponsors'];
        $exhibitors = $options['exhibitors'];
        $tags = $options['tags'];


        $builder
            
            ->add('type', ChoiceType::class, [ 
                'choices' => [
                    ($lng == 'en_EN' ? 'Conference' : 'Conférence') =>0, 
                    ($lng == 'en_EN' ? 'Workshop' : 'Atelier') =>1, 
                    
                ], 
                 
                'expanded'=>true,
                'label' => $lng == 'en_EN' ? 'Type' : 'Type' , 
                'row_attr' => ['class' => 'form-group'],
                'attr' => array(  "event-selector"=>"type" , 'class' => 'form-control  mb-3 ' )
            ])

           
            ->add('participants', ChoiceType::class, [ 
                'choices' => $participants,  
                'multiple'=>true,
                'label' => $lng == 'en_EN' ? 'Speakers' : 'Intervenants' , 
                'row_attr' => ['class' => 'form-group'],
                'attr' => array(  "event-selector"=>"participants" , 'class' => 'form-control  mb-3 ' )
            ])
            ->add('sponsors', ChoiceType::class, [ 
                
                'choices' => $sponsors,  
                'multiple'=>true,
                'label' => $lng == 'en_EN' ? 'Sponsors' : 'Sponsors' , 
                'row_attr' => ['class' => 'form-group'],
                'attr' => array(  "event-selector"=>"sponsors" , 'class' => 'form-control  mb-3 ' )
            ])
            ->add('exposers', ChoiceType::class, [ 
                'choices' => $exhibitors,  
                'multiple'=>true,
                'label' => $lng == 'en_EN' ? 'Exhibitors' : 'Exposants' , 
                'row_attr' => ['class' => 'form-group'],
                'attr' => array(  "event-selector"=>"exposers" , 'class' => 'form-control  mb-3 ' )
            ])



            ->add('title', TextType::class, [ 
                'label' => $lng == 'en_EN' ? 'Title' : 'Titre', 
                'row_attr' => ['class' => 'form-group'],
                'attr' => array('class' => 'form-control  mb-3', 'placeholder' => '', "event-selector"=>"title")
            ])

            ->add('description', CKEditorType::class, [
                'config'=>array(
                    'toolbar'=>'full',
                    "colorButton_enableAutomatic"=>true
                ),
                'required'=>true,
                'label' => $lng == 'en_EN' ? 'Description' : "Description",  
                'row_attr' => ['class' => 'form-group'],
                'attr' => array(   'class' => 'form-control  mb-3 ', "event-selector"=>"description")
            ])
            ->add('startDate', DateTimeType::class, [
                'row_attr' => ['class' => 'form-group'],
                'required'=>true,
                'label' => $lng == 'en_EN' ? 'starts at' : "Débute à",  
                'widget' => 'single_text',
                'attr' => array('class' => 'form-control  mb-3 ', "event-selector"=>"startDate" )
            ])
            ->add('endDate', DateTimeType::class, [
                'row_attr' => ['class' => 'form-group'],
                'required'=>true,
                'label' => $lng == 'en_EN' ? 'Ends at' : "Se termine à",  
                'widget' => 'single_text',
                'attr' => array('class' => 'form-control  mb-3 ', "event-selector"=>"endDate" )
            ])
            ->add('timezone', TimezoneType::class, [ 
                'label' => $lng == 'en_EN' ? 'Time zone' : 'Fuseau horaire', 
                'row_attr' => ['class' => 'form-group'],
                'attr' => array('class' => 'form-control  mb-3', 'placeholder' => '', "event-selector"=>"Fuseau horaire")
            ])
            ->add('tags', ChoiceType::class, [ 
                'choices' => $tags,
                'multiple'=>true ,
                'label' => $lng == 'en_EN' ? 'Tags' : 'Tags' , 
                'row_attr' => ['class' => 'form-group'],
                'attr' => array(  "event-selector"=>"roomKeyWords" , 'class' => 'form-control  mb-3 ' )
            ])

            

 

            ->add('mode', ChoiceType::class, [ 
                'choices' => [ 
                    ($lng == 'en_EN' ? 'On line' : 'En ligne') =>0, 
                    ($lng == 'en_EN' ? 'Physical' : 'Physique') =>1, 
                    ($lng == 'en_EN' ? 'Hybrid' : 'Hybride') =>2, 
 
                ],
                'label' => $lng == 'en_EN' ? 'Mode' : 'Mode' , 
                'row_attr' => ['class' => 'form-group'],
                'attr' => array(  "event-selector"=>"roomKeyWords" , 'class' => 'form-control  mb-3 ' )
            ])


            ->add('liveLinkURL', TextType::class, [ 
                'label' => $lng == 'en_EN' ? 'Live link' : 'Lien du Live JJ', 
                'row_attr' => ['class' => 'form-group'],
                'attr' => array('class' => 'form-control  mb-3', 'placeholder' => '', "event-selector"=>"liveLinkURL")
            ])
            ->add('liveTranslationLinkURL', TextType::class, [ 
                'label' => $lng == 'en_EN' ? 'Live translation link' : 'Lien avec traduction JJ', 
                'row_attr' => ['class' => 'form-group'],
                'attr' => array('class' => 'form-control  mb-3', 'placeholder' => '', "event-selector"=>"liveTranslationLinkURL")
            ])
            ->add('reShareLinkURL', TextType::class, [ 
                'label' => $lng == 'en_EN' ? 'Live Replay Link' : 'Lien du rediffusion du Live', 
                'row_attr' => ['class' => 'form-group'],
                'attr' => array('class' => 'form-control  mb-3', 'placeholder' => '', "event-selector"=>"reShareLinkURL")
            ])
            ->add('reShareTranslationLinkURL', TextType::class, [ 
                'label' => $lng == 'en_EN' ? 'Link of the Replay Translation of the Live' : 'Lien du rediffusion avec traduction du Live', 
                'row_attr' => ['class' => 'form-group'],
                'attr' => array('class' => 'form-control  mb-3', 'placeholder' => '', "event-selector"=>"reShareTranslationLinkURL")
            ])
           
           
            ->add('mainSponsorPhotoURL', FileType::class, [ 
                'mapped'=>false,
                'label' => $lng == 'en_EN' ? 'Sponsor image' : 'Image du sponsor', 
                'row_attr' => ['class' => 'form-group'],
                'attr' => array('class' => 'form-control  mb-3', 'placeholder' => '', "event-selector"=>"mainSponsorPhotoURL")
            ])
            ->add('canBeShowenInProgrammePage', CheckboxType::class, [ 
                'label' => $lng == 'en_EN' ? 'Can be displayed in the program page' : "Affiché dans la page du programme", 
                'row_attr' => ['class' => 'form-group'],
                'attr' => array('class' => ' mb-3 d-block' )
            ])
            
            
            

            ->add('manageInteractivity', CheckboxType::class, [ 
                'label' => $lng == 'en_EN' ? 'Manage session interactivity' : "Gérer l'interactivité de la session", 
                'row_attr' => ['class' => 'form-group'],
                'attr' => array('class' => ' mb-3 d-block' )
            ])
            ->add('canChat', CheckboxType::class, [ 
                'label' => $lng == 'en_EN' ? 'Allow participants to chat' : "Autoriser la discussion entre les participants", 
                'row_attr' => ['class' => 'form-group'],
                'attr' => array('class' => ' mb-3 d-block' )
            ])
            ->add('activateSondage', CheckboxType::class, [ 
                'label' => $lng == 'en_EN' ? 'Enable polls for this session' : "Activer le sondage pour cette session", 
                'row_attr' => ['class' => 'form-group'],
                'attr' => array('class' => ' mb-3 d-block' )
            ])
            ->add('activateParticipantsList', CheckboxType::class, [ 
                'label' => $lng == 'en_EN' ? 'Activate the list of participants' : "Afficher la liste des participants", 
                'row_attr' => ['class' => 'form-group'],
                'attr' => array('class' => ' mb-3 d-block' )
            ])
            ->add('activateQuestionResponse', CheckboxType::class, [ 
                'label' => $lng == 'en_EN' ? 'Enable Q&A for this session' : "Autoriser les questions et réponses pour cette session", 
                'row_attr' => ['class' => 'form-group'],
                'attr' => array('class' => ' mb-3 d-block' )
            ])
            ->add('sendQuestioninPrivate', CheckboxType::class, [ 
                'label' => $lng == 'en_EN' ? 'Send questions privately only' : "Autoriser les questions en privé uniquement", 
                'row_attr' => ['class' => 'form-group'],
                'attr' => array('class' => ' mb-3 d-block' )
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
                foreach ($data['tags'] as $key => $value) {
                    $tmp[$value]=$value;
                }

                $formModifier($event->getForm(), $tmp );
            }
        );


    }






        


    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RoomProgramm::class,
            'lng'=>null,
            'participants'=>[],
            'sponsors'=>[],
            'exhibitors' => [],
            'tags' => []
            
        ]);
    }
}
