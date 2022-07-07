<?php

namespace App\Form;

use App\Entity\EventsLanguages;
use App\Entity\MeetingSessions;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MeetingSessionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $lng = $options['lng'];

        $builder
            ->add('name', TextType::class, [ 
                'label' => $lng == 'en_EN' ? 'Session name' : "Nom de la séance", 
                'row_attr' => ['class' => 'form-group'],
                'attr' => array('class' => 'form-control  mb-3', 'placeholder' => '')
            ])
            
            ->add('place', TextType::class, [ 
                'label' => $lng == 'en_EN' ? 'Event place' : "Lieu de l'événement ", 
                'row_attr' => ['class' => 'form-group'],
                'attr' => array('class' => 'form-control  mb-3', 'placeholder' => '')
            ])
            ->add('dateAndTime', DateTimeType::class, [
                'row_attr' => ['class' => 'form-group'],
                'required'=>true,
                'label' => $lng == 'en_EN' ? 'Start at' : "Date et heure de la début de la séance",  
                'widget' => 'single_text',
                'attr' => array('class' => 'form-control  mb-3 ', "event-selector"=>"startDate" )
            ])
            ->add('endDateTime', DateTimeType::class, [
                'row_attr' => ['class' => 'form-group'],
                'required'=>true,
                'label' => $lng == 'en_EN' ? 'Ends at' : "Date et heure de la fin de la séance",  
                'widget' => 'single_text',
                'attr' => array('class' => 'form-control  mb-3 ', "event-selector"=>"startDate" )
            ])


            
            ->add('minutesPerRDV', IntegerType::class, [ 
                'label' => $lng == 'en_EN' ? 'Number of minutes per appointment of the Session' : "Nombre de minutes par rendez-vous (supprimer de la séance)", 
                'row_attr' => ['class' => 'form-group'],
                'attr' => array('class' => 'form-control  mb-3', 'placeholder' => '')
            ])
            ->add('language', EntityType::class, [
                'required'=>true,
                
                'label' => $lng == 'en_EN' ? 'Language' : "Langue de la séance", 
                'class' => EventsLanguages::class, 
                'attr' => array('class' => 'form-control  mb-3'),
                'row_attr' => ['class' => 'form-group'],
                 
            ])
            
            ->add('interpretation', ChoiceType::class, [
                'required'=>true,
                'label' => $lng == 'en_EN' ? 'Interpretation' : "Interprétation",  
                'row_attr' => ['class' => 'form-group'],
                'attr' => array(  "event-selector"=>"eventName" , 'class' => 'form-control  mb-3 '),
                'required'=>true,
                'choices'  => [
                    $lng == 'en_EN' ? 'with' : "avec"=> 0,
                    $lng == 'en_EN' ? 'without' : "sans"=> 1,
                    ],  
            ])
            ->add('nbrTablesPerSession', IntegerType::class, [ 
                'label' => $lng == 'en_EN' ? 'Number of tables' : "Nombre de tables", 
                'row_attr' => ['class' => 'form-group'],
                'attr' => array('class' => 'form-control  mb-3', 'placeholder' => '')
            ])
            ->add('tableRotation', ChoiceType::class, [
                'required'=>false,
                'label' => $lng == 'en_EN' ? 'Table rotation' : "Rotation des tables",  
                'row_attr' => ['class' => 'form-group'],
                'attr' => array(  "event-selector"=>"eventName" , 'class' => 'form-control  mb-3 '),
                'required'=>true,
                'choices'  => [
                    $lng == 'en_EN' ? 'fixed' : "fix"=> 0,
                    $lng == 'en_EN' ? 'rotating' : "tournante"=> 1,
                    ],  
            ])
            ->add('matchmaking', ChoiceType::class, [
                'required'=>false,
                'label' => $lng == 'en_EN' ? 'Matchmaking' : "Matchmaking",  
                'row_attr' => ['class' => 'form-group','id'=>'matchmaking_row',],
                'attr' => array(  "event-selector"=>"eventName" , 'class' => 'form-control  mb-3 '),
                'required'=>true,
                'choices'  => [
                    $lng == 'en_EN' ? 'Intelligent' : "Intelligent"=> 0,
                    $lng == 'en_EN' ? 'Manual' : "Manuel "=> 1,
                    
                    ],  
            ])
            ->add('byWho', ChoiceType::class, [
                'required'=>false,
                'label' => $lng == 'en_EN' ? 'By who' : "Par qui ?",  
                'row_attr' => ['class' => 'form-group','id'=>'byWho_row',],
                'attr' => array(  "event-selector"=>"eventName" , 'class' => 'form-control  mb-3 '),
                'required'=>true,
                'choices'  => [
                    $lng == 'en_EN' ? 'By participant' : "Par le participant"=> 0,
                    $lng == 'en_EN' ? 'By the organizer' : "Par l'organisateur"=> 1,
                    $lng == 'en_EN' ? 'both' : "Par les deux"=> 2,
                    
                    ],  
            ])
             

            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MeetingSessions::class,
            'lng'=>null
        ]);
    }
}
