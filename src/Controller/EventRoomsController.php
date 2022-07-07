<?php

namespace App\Controller;

use App\Entity\EventRooms;
use App\Entity\Events;
use App\Entity\RoomAccessProfiles;
use App\Entity\RoomParticipantsInvitations;
use App\Form\EventRoomsType;
use App\Repository\EventRoomsRepository;
use App\Repository\MailTemplateRepository;
use App\Repository\MailTypesRepository;
use App\Repository\ParticipantRepository;
use App\Repository\ProfileRepository;
use App\Repository\RoomAccessProfilesRepository;
use App\Repository\RoomParticipantsInvitationsRepository;
use App\Repository\TagsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/common/event-rooms")
 */
class EventRoomsController extends AbstractController
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
     * @Route("/privacy/configuration/{id}", name="room_privacy_route")
     */
    public function privacy(TranslatorInterface $translator,SessionInterface $session, EventRooms $eventRoom, Request $request, ProfileRepository $profileRepository, RoomAccessProfilesRepository $roomAccessProfilesRepository, MailTypesRepository $mailTypesRepository, MailTemplateRepository $mailTemplateRepository, RoomParticipantsInvitationsRepository $roomParticipantsInvitationsRepository, ParticipantRepository $participantRepository ): Response
    {

        $method = $request->getMethod();

        if ($method == 'POST') {
            $params = $request->request;

            if ($params->get('privacy-form-2') != null ) { 
                if ($params->get('profile_id')) {

                    // first delete em all !!
                    $all = $roomAccessProfilesRepository->findBy(['room'=>$eventRoom->getId()]);

                    foreach ($all as $key => $value) {
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->remove($value);
                        $entityManager->flush();
                    }
                    
                    for ($i=0; $i < sizeof($params->get('profile_id'))  ; $i++) { 
                        $tmp = $params->get('profile_id')[$i];

                        $roomAccessProfile = new RoomAccessProfiles();

                        $roomAccessProfile->setRoom($eventRoom);
                        $roomAccessProfile->setProfile($profileRepository->findOneBy(['id'=>$tmp]));

                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($roomAccessProfile);
                        $entityManager->flush();
                        


                    }
                    
                    $message = $translator->trans(
                        'Donnée mise a jour avec succès',
                        array(),
                        'messages',
                        $this->detectLanguage($session)
                    );

                    return $this->redirectToRoute('events_details', ['id'=>$eventRoom->getEvent()->getId(),"ok"=>$message], Response::HTTP_SEE_OTHER);
                }
            }


            if ($params->get('privacy-form-3') != null ) { 
                if ($params->get('participants')) {

                     
                    
                    for ($i=0; $i < sizeof($params->get('participants'))  ; $i++) { 
                        $tmp = $params->get('participants')[$i];

                        
                        

                        // check if invitation is already  sent !! 

                        $check = $roomParticipantsInvitationsRepository->findOneBy(['room'=>$eventRoom,'participant'=>$tmp]);

                        if ($check == null) {
                            $invitaion = new RoomParticipantsInvitations();

                            $invitaion->setRoom($eventRoom);
                            $invitaion->setParticipant($participantRepository->findOneBy(['id'=>$tmp]));


                            // send inviation by mail !!!


                            $entityManager = $this->getDoctrine()->getManager();
                            $entityManager->persist($invitaion);
                            $entityManager->flush();

                        }

 
                    }
                    
                    $message = $translator->trans(
                        'Invitations envoyées avec succès',
                        array(),
                        'messages',
                        $this->detectLanguage($session)
                    );

                    return $this->redirectToRoute('events_details', ['id'=>$eventRoom->getEvent()->getId(),"ok"=>$message], Response::HTTP_SEE_OTHER);

                     
                    
                }else{
                    return $this->redirectToRoute('events_details', ['id'=>$eventRoom->getEvent()->getId() ], Response::HTTP_SEE_OTHER);

                    
                }
            }

            
        } 
        



        // case profiles

        $haveInvitatinEmailTemplate = $mailTemplateRepository->findOneBy(['type'=>8]);


        return $this->render('event_rooms/room-privacy.html.twig', [
            
            'event_room'=>$eventRoom,
            'haveInvittionMail'=> $haveInvitatinEmailTemplate != null ? true : false
        ]);
    }

    /**
     * @Route("/new/event/{id}", name="event_rooms_new", methods={"GET","POST"})
     */
    public function new(Request $request,Events $event, TagsRepository $tagsRepository, ProfileRepository $profileRepository): Response
    {
        $eventRoom = new EventRooms();
        $eventRoom->setEvent($event);



        $tags = [];
               
        $profilesTMP = $profileRepository->findBy(['event'=>$eventRoom->getEvent()->getId()]);

        $profiles = [];

        foreach ($profilesTMP as $key => $value) {
            $profiles[$value->getLabel()]=$value->getId();
        }
 


       /* $tmp = $tagsRepository->findAll();
 

        foreach ( $tmp as $key => $value) { 
            $tags[$value->getTag()] = $value->getTag();
             
        }*/

          
 
        
        $form = $this->createForm(EventRoomsType::class, $eventRoom, ['tags'=>$tags,'profiles'=>$profiles]);
        $form->handleRequest($request); 
        
        if ($form->isSubmitted()  && $form->isValid() ) {

 


             /** @var UploadedFile $image */
             
             $image = $form->get('photoURL')->getData();
            
             if ($image) {
                 $newFilename = uniqid().'.'.$image->guessExtension();
 
                 // Move the file to the directory where brochures are stored
                 try { 
                     $image->move('assets/img/events/rooms/',
                         $newFilename
                     );
                     $eventRoom->setPhotoURL('/assets/img/events/rooms/'.$newFilename);
                 } catch (FileException $e) { 
                    $eventRoom->setPhotoURL('/assets/img/events/rooms/null.png');
                 } 
                 
             }else{
                $eventRoom->setPhotoURL('/assets/img/events/rooms/null.png');
             }


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($eventRoom);
            $entityManager->flush();


            return $this->redirectToRoute('events_details', ['id'=>$eventRoom->getEvent()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('event_rooms/new.html.twig', [
            'event_room' => $eventRoom,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="event_rooms_show", methods={"GET"})
     */
    public function show(EventRooms $eventRoom): Response
    {
        return $this->render('event_rooms/show.html.twig', [
            'event_room' => $eventRoom,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="event_rooms_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EventRooms $eventRoom, ProfileRepository $profileRepository): Response
    {

        
        
        $profilesTMP = $profileRepository->findBy(['event'=>$eventRoom->getEvent()->getId()]);

        $profiles = [];

        foreach ($profilesTMP as $key => $value) {
            $profiles[$value->getLabel()]=$value->getId() ;
        }

        

        $tmp = [];
        foreach ($eventRoom->getKeyWords() as $key => $value) {
            $tmp[$value]=$value;
        }



        $form = $this->createForm(EventRoomsType::class, $eventRoom,['tags'=>$tmp,'profiles'=>$profiles]);
        $form->handleRequest($request);

 

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $image */
             
            $image = $form->get('photoURL')->getData();
            
            if ($image) {
                $newFilename = uniqid().'.'.$image->guessExtension();

                // Move the file to the directory where brochures are stored
                try { 
                    $image->move('assets/img/events/rooms/',
                        $newFilename
                    );
                    $eventRoom->setPhotoURL('/assets/img/events/rooms/'.$newFilename);
                } catch (FileException $e) { 
                   $eventRoom->setPhotoURL('/assets/img/events/rooms/null.png');
                } 
                
            }


            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('events_details', ['id'=>$eventRoom->getEvent()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('event_rooms/edit.html.twig', [
            'event_room' => $eventRoom,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="event_rooms_delete", methods={"POST"})
     */
    public function delete(Request $request, EventRooms $eventRoom): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eventRoom->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($eventRoom);
            $entityManager->flush();
        }

        return $this->redirectToRoute('event_rooms_index', [], Response::HTTP_SEE_OTHER);
    }
}
