<?php

namespace App\Controller;

use App\Entity\EventAssociatedProfileFeilds;
use App\Entity\EventProfiles;
use App\Entity\Events;
use App\Entity\Notes;
use App\Form\ClientUpdateType;
use App\Form\EventProfilesType;
use App\Form\NotesType;
use App\Models\ClientModel;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/common")
 */

class ProfilesController extends AbstractController
{
    
    public function detectLanguage(SessionInterface $session): ?string
    {
 
        $locale = $session->get('lng');

        if ($locale == null ) { 

            return 'fr';
        }else{
            return $session->get('lng');
        }
 
    }



    /**
     * @Route("/create-new-profile/event/{id}", name="create_new_profile")
     */
    public function create_new_profile(Request $request, Events $event , SessionInterface $session): Response
    {
         
        $eventProfile = new EventProfiles();
        $form = $this->createForm(EventProfilesType::class, $eventProfile,['lng'=>$this->detectLanguage($session)]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $eventProfile->setEvent($event);
            $eventProfile->setUniqueID(uniqid($event->getId().'_'));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($eventProfile);
            $entityManager->flush();

            return $this->redirectToRoute('events_details', ["id"=>$event->getId()], Response::HTTP_SEE_OTHER);
        } 
        return $this->renderForm('utilities/add-profile.html.twig', [ 
            'event'=>$event,
            'event_profile' => $eventProfile,
            'form' => $form,

        ]);
    }



    
    /**
     * @Route("/search-feilds-by-event", name="search_for_feilds", methods={"POST"})
     */
    public function search_for_feilds(Request $request): JsonResponse
    { 
        $params = $request->request; 

        $profile = $params->get('profile');


        $conn = $this->getDoctrine()->getManager()
        ->getConnection();
        
        $sql = "SELECT * FROM `event_profile_feilds` WHERE `event_id` = ?  AND  `id` NOT IN ( SELECT `field_id` AS `id` FROM `event_associated_profile_feilds` WHERE `profile_id` = ? )  AND  ( `label_fr` LIKE '%".$params->get('query')."%' OR `label_en` LIKE '%".$params->get('query')."%' ) ";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $params->get('event'));
        $stmt->bindValue(2, $profile);
        
        $stmt->execute();

        
        $list =$stmt->fetchAll();

        return $this->json($list);

    }





    /**
     * @Route("/add-feilds-to-profile", name="add_feild_to_profile", methods={"POST"})
     */
    public function add_feild_to_profile(Request $request,SessionInterface $session): JsonResponse
    { 
        $params = $request->request;

        $profile = $params->get('profile');
        $feild = $params->get('feild');
        

        $conn = $this->getDoctrine()->getManager()
        ->getConnection();
        
        $sql = "SELECT * FROM `event_associated_profile_feilds` WHERE `profile_id` = ? AND `field_id` = ? ";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $profile);
        $stmt->bindValue(2, $feild);
        
        $stmt->execute();

        
        $list =$stmt->fetchAll();

        if (sizeof($list) == 0) {

            $conn = $this->getDoctrine()->getManager()
            ->getConnection();
            
            $sql = "INSERT INTO `event_associated_profile_feilds`( `profile_id`, `field_id`) VALUES (?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(1, $profile);
            $stmt->bindValue(2, $feild);
            
            $stmt->execute();


            return $this->json(["success"=>true,"message"=>   ( $session->get('lng') =='en_EN' ?"Feild successfully added":'champs ajouté avec succés')  ]);
        }else{
            return $this->json(["success"=>false,"message"=>   ( $session->get('lng') =='en_EN' ?"Feild already in user":'champs déja utilisé'   )   ]);
        }

        

    }



    /**
     * @Route("/remove-feild-from-profile", name="delete_feild_from_profie", methods={"POST"})
     */
    public function delete(Request $request ,SessionInterface $session): Response
    {
        

            $params = $request->request;

            $association = $params->get('association'); 

            $conn = $this->getDoctrine()->getManager()
            ->getConnection();
            
            $sql = "DELETE FROM `event_associated_profile_feilds` WHERE `id` = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(1, $association); 
            
            $stmt->execute(); 
            return $this->json(["success"=>true,"message"=>   ( $session->get('lng') =='en_EN' ?"Feild successfully deleted":'champs supprimé avec succés')  ]);
         
    }




    



}
