<?php

namespace App\Form;

use App\Entity\EventProfiles;
use App\Entity\EventRooms;
use App\Entity\EventRoomsPrivacy;
use App\Entity\Tags;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventRoomsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $lng = $options['lng'];
        $tags = $options['tags'];
        $profiles = $options['profiles'];
        
        $builder
            ->add('label', TextType::class, [
                'required'=>false,
                'label' => $lng == 'en_EN' ? 'Label' : 'Label' , 
                'row_attr' => ['class' => 'form-group'],
                'attr' => array(  "event-selector"=>"roomName" , 'class' => 'form-control  mb-3 ', )
            ])
            ->add('description', CKEditorType::class, [
                'config'=>array(
                    'toolbar'=>'full',
                    "colorButton_enableAutomatic"=>true
                ),
                'row_attr' => ['class' => 'form-group'],
                'required'=>true,
                'label' => $lng == 'en_EN' ? 'Description' : 'Déscription' , 
                'attr' => array('class' => 'form-control  mb-3 ', 'placeholder' => '' , 'rows'=>'4'  )
            ])
            ->add('photoURL', FileType::class, [
                'required'=>false,
                'label' => "  ",   
                "mapped"=>false, 
                
                'row_attr' => ['class' => 'form-group d-none'],
                'attr' => array(  "event-selector"=>"roomPhotoURL" , 'class' => 'form-control' )
            ])
            
            ->add('photoAlt', TextType::class, [
                'required'=>false,
                'label' => $lng == 'en_EN' ? 'Alt' : 'Alt' , 
                'row_attr' => ['class' => 'form-group'],
                'attr' => array(  "event-selector"=>"photoAlt" , 'class' => 'form-control  mb-3 ', )
            ])


            ->add('keyWords', ChoiceType::class, [ 
                'choices' => $tags,
                'multiple'=>true ,
                'label' => $lng == 'en_EN' ? 'Keywords' : 'Mots clés' , 
                'row_attr' => ['class' => 'form-group'],
                'attr' => array(  "event-selector"=>"roomKeyWords" , 'class' => 'form-control  mb-3 ' )
            ])


            ->add('maximumNumberOfParticipants', IntegerType::class, [
                'required'=>false,
                'label' => $lng == 'en_EN' ? 'Maximum number of participants' : 'Nombre maximum de participants' , 
                'row_attr' => ['class' => 'form-group'],
                'attr' => array(  "event-selector"=>"maximumNumberOfParticipants" , 'class' => 'form-control  mb-3 ', )
            ])
            ->add('youtubeShare', CheckboxType::class, [
                'required'=>false,
                'label' => $lng == 'en_EN' ? 'YouTube sharing' : 'Partage YouTube' , 
                'row_attr' => ['class' => 'form-group'],
                'attr' => array(  "event-selector"=>"youtubeShare" , 'class' => 'd-block mb-3 ', )
            ])
            
            ->add('privacy', EntityType::class, [
                'class'=>EventRoomsPrivacy::class,
                'choice_label'=> $lng == 'en_EN' ? 'labelEn' : 'label' , 
                'required'=>true,
                'label' => $lng == 'en_EN' ? 'Privacy' : 'Confidentialité' , 
                'row_attr' => ['class' => 'form-group'],
                'attr' => array(  "event-selector"=>"privacy" , 'class' => 'form-control d-block mb-3', )
            ])
            ->add('workerProfiles',  ChoiceType::class, [ 
                'choices' => $profiles, 
                'multiple'=>true ,
                'expanded'=>true, 
                  
                'required'=>true,
                'label' => $lng == 'en_EN' ? 'Who can participate' : 'Profils autorisé à intervenir' , 
                'row_attr' => ['class' => 'form-group'],
                'attr' => array(  "event-selector"=>"participants" , 'class' => 'form-control d-block mb-3', )
            ])
        ;


        $formModifier = function (FormInterface $form, $choices ) {
             

            $form->add('keyWords', ChoiceType::class, [ 
                'choices' => $choices,
                'multiple'=>true ,
                'label' =>  'Keywords'  , 
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
                foreach ($data['keyWords'] as $key => $value) {
                    $tmp[$value]=$value;
                }

                $formModifier($event->getForm(), $tmp );
            }
        );


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EventRooms::class,
            'lng'=>null,
            'tags'=>[],
            'profiles' => []
        ]);
    }
}
