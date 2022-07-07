<?php

namespace App\Form;

use App\Entity\EventProfiles;
use App\Entity\MailTemplate;
use App\Entity\MailTypes;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MailTemplateType extends AbstractType
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
            ->add('object', TextType::class, [ 
                'label' => $lng == 'en_EN' ? 'Object' : 'Objet', 
                'row_attr' => ['class' => 'form-group'],
                'attr' => array('class' => 'form-control  mb-3', 'placeholder' => '')
            ])
            ->add('content', CKEditorType::class, [
                'config'=>array(
                    'toolbar'=>'full',
                    "colorButton_enableAutomatic"=>true
                ),
                'required'=>true,
                'label' => $lng == 'en_EN' ? 'Content' : "Contenu",  
                'row_attr' => ['class' => 'form-group'],
                'attr' => array( "event-selector"=>"eventName" , 'class' => 'form-control  mb-3 ')
            ])
            ->add('type', EntityType::class, [
                'required'=>true,  
                'choice_label'=>$lng == 'en_EN' ? 'labelEN' : "label", 
                'label' => $lng == 'en_EN' ? 'Type' : "Type", 
                'class' => MailTypes::class, 
                'attr' => array('class' => 'form-control  mb-3'),
                'row_attr' => ['class' => 'form-group'],
                 
            ])

            ->add('profiles', EntityType::class, [
                'required'=>true,
                'multiple'=>true,
                "expanded"=>true,
                'mapped'=>true,
                
                'label' => $lng == 'en_EN' ? 'Profiles' : "Profils", 
                'class' => EventProfiles::class, 
                'attr' => array('class' => 'form-control  mb-3'),
                'row_attr' => ['class' => 'form-group'],
                 
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MailTemplate::class,
            'lng'=>null
        ]);
    }
}
