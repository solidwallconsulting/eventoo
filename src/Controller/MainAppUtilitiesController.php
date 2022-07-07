<?php

namespace App\Controller;

use App\Entity\AppointmentRequest;
use App\Entity\Notifications;
use App\Repository\AppointmentRequestRepository;
use App\Repository\BtBMeetingRoomRepository;
use App\Repository\ParticipantRepository;
use App\Repository\RoomSessionAccessRepository;
use App\Repository\UserRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; 
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class MainAppUtilitiesController extends AbstractController
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
     * @Route("/main-app/networking-api/send-invitation", name="send_invitation_api_route", methods={"POST"})
     */
    public function networking(  BtBMeetingRoomRepository $btBMeetingRoomRepository, RoomSessionAccessRepository $roomSessionAccessRepository, SessionInterface $session, Request $request,ParticipantRepository $participantRepository, AppointmentRequestRepository $appointmentRequestRepository): JsonResponse
    {

        $body = $request->request;

        $userTarget = $participantRepository->findOneBy(['id'=>$body->get('participantID')])->getUser();

        $iCanOnlySend = 0;
        
        // get the business room;

        $room = $btBMeetingRoomRepository->findOneBy(['id'=>$body->get('roomID')]);

        // check if room is closed

        if ($room->getInvitationsState() == 0 ) {
            $message="Sending appointments is closed";

            if ($this->detectLanguage($session) =='fr' ) {
                $message="L'envoi des rendez-vous est clôturé";
            }

            $response = [ 'success'=>false,"message"=> $message ];

            return $this->json($response);
        }

        // check if room is public

        if ($room->getAccess() == 0) {
            $iCanOnlySend = $room->getMaximumInvitationNumber();
        }else{
            // find my access invitation

            $sessionAccess = $room->getRoomSessionAccesses();

            foreach ($sessionAccess as $key => $roomAccess) {
                if ($roomAccess->getParticipant()->getUser()->getId() == $this->getUser()->getId()) {
                    // yep it's me
                    $iCanOnlySend = $roomAccess->getInvitations();
                }
            }
        }

        $iDidSentInThisRoom = 0;

        $tmp = $appointmentRequestRepository->findBy(['sender'=>$this->getUser()->getId(),'roomBtB'=>$room->getId()]);

        $iDidSentInThisRoom = sizeof($tmp);



        if ($iDidSentInThisRoom == $iCanOnlySend) {
            $message="You reached your invitations limits";

            if ($this->detectLanguage($session) =='fr' ) {
                $message="Vous avez atteint vos limites d'invitations";
            }

            $response = [ 'participantID'=>$body->get('participantID'),'success'=>true,"message"=> $message, 'totalSent'=>$iDidSentInThisRoom,'icanOnlySend'=>$iCanOnlySend ];

            return $this->json($response);


        } else {
           // check if invitationalready sent !!

        $checkOne = $appointmentRequestRepository->findOneBy(['roomBtB'=>$room->getId(),'sender'=>$this->getUser()->getId(),'receiver'=>$userTarget->getId()]);
        $checkTwo = $appointmentRequestRepository->findOneBy(['roomBtB'=>$room->getId(),'receiver'=>$this->getUser()->getId(),'sender'=>$userTarget->getId()]);


        if ($checkOne == null && $checkTwo == null) {
            $event=$this->getUser()->getParticipant()->getProfile()->getEvent();


            $invitation = new AppointmentRequest();

            $invitation->setSendDate(new DateTime());

            $invitation->setSender($this->getUser());
            
            $invitation->setSender($this->getUser());

            $invitation->setEvent($event);

            $invitation->setRoomBtB($room);

            $invitation->setReceiver($userTarget);


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($invitation);
            $entityManager->flush();

            // generate notification for the target participant

            $lng = $this->detectLanguage($session); 
            
            $notification = new Notifications();
            $notification->setTitle( $lng == 'fr' ? 'Nouvelle invitation' :'New invitation'  );
            
            $notification->setContent( $lng == 'fr' ? $this->getUser()->getFirstName().' '.$this->getUser()->getLastName().' vous a envoyé une demande de rendez-vous' :$this->getUser()->getFirstName().' '.$this->getUser()->getLastName().' sent you a meeting request '  );
            $notification->setDate(new DateTime());
            $notification->setUser($userTarget);
            $notification->setSeen(0);
            $notification->setType(0); // 

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($notification);
            $entityManager->flush();


            $message="Your invitation has been sent successfully";

            if ($this->detectLanguage($session) =='fr' ) {
                $message='Votre invitation a été envoyée avec succès';
            }
            $response = [ 'participantID'=>$body->get('participantID'),'success'=>true,"message"=> $message, 'totalSent'=>$iDidSentInThisRoom,'icanOnlySend'=>$iCanOnlySend ];

            return $this->json($response);


        }else{

            if ($checkTwo != null) {
                $message="Looks like you already have an invitation from this participant.";

                if ($this->detectLanguage($session) =='fr' ) {
                    $message='Il semble que vous ayez déjà reçu une invitation de la part de ce participant.';
                }
                $response = [ 'participantID'=>$body->get('participantID'),'success'=>false,"message"=> $message ];


                return $this->json($response);




            }else if ($checkOne != null)  {
                $message="Invitation already sent.";

                if ($this->detectLanguage($session) =='fr' ) {
                    $message='Invitation déjà envoyée';
                }
                $response = [ 'participantID'=>$body->get('participantID'),'success'=>false,"message"=> $message ];


                return $this->json($response);
            }

        }
        } 
 
    }






    
    /**
     * @Route("/main-app/networking-api/accept-invitation/{id}/{status}", name="change_invitation_state_api_route", methods={"GET","POST"})
     */
    public function networking_appointment_status(SessionInterface $session, AppointmentRequest $appointmentRequest, $status ,  AppointmentRequestRepository $appointmentRequestRepository): RedirectResponse{
        if ( $status == 1 ) {
            $iCanOnlyAccept = 0;
            // before we accept

            // how many confirmed meetng can i reach ??

            $access = $appointmentRequest->getRoomBtB()->getAccess();


            if ($access == 0) {
                

                $iCanOnlyAccept = $appointmentRequest->getRoomBtB()->getNbrOfConfirmedMeetingPerMember();

                // how many did i accept in this room ?
                $confirmedIncomeRequest = $appointmentRequestRepository->findBy(['roomBtB'=>$appointmentRequest->getRoomBtB()->getId(),'receiver'=>$this->getUser()->getId(),'status'=>1]);
                $confirmedSentRequest = $appointmentRequestRepository->findBy(['roomBtB'=>$appointmentRequest->getRoomBtB()->getId(),'sender'=>$this->getUser()->getId(),'status'=>1]);
                

               
                $iHaveThisMuchAccepted = sizeof($confirmedIncomeRequest) + sizeof($confirmedSentRequest);

                if ( $iHaveThisMuchAccepted < $iCanOnlyAccept  ) {
                    $appointmentRequest->setStatus($status); 

                    $this->getDoctrine()->getManager()->flush();

                    $lng = $this->detectLanguage($session); 


                    if ($status == 1) {
                        $notification = new Notifications();
                        $notification->setTitle( $lng == 'fr' ? 'Invitation' :'Invitation'  );
                        
                        $notification->setContent( $lng == 'fr' ? $this->getUser()->getFirstName().' '.$this->getUser()->getLastName().' a accepté votre demande de rendez-vous' :$this->getUser()->getFirstName().' '.$this->getUser()->getLastName().' accepted you meeting request'  );
                        $notification->setDate(new DateTime());
                        $notification->setUser($appointmentRequest->getSender());
                        $notification->setSeen(0);
                        $notification->setType(0); // 
            
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($notification);
                        $entityManager->flush();
                    } 

                    

                    

                    
                    return $this->redirectToRoute('networking_liste_of_invitation_route',[  'room'=>$appointmentRequest->getRoomBtB()->getId()]); 
                }else{

                    $message="You reached the maximum number of appointments";
                   
                    if ($this->detectLanguage($session) =='fr' ) {
                       
                        $message = 'Vous avez atteint le nombre maximum de rendez-vous';
                    } 

                    return $this->redirectToRoute('networking_liste_of_invitation_route',[ 'error'=>$message, 'room'=>$appointmentRequest->getRoomBtB()->getId()]); 
                }


            } else if ( $access == 1 ) {
                // find my access !!!
                $passes = $appointmentRequest->getRoomBtB()->getRoomSessionAccesses();

                foreach ($passes as $key => $pass) {
                    if ( $pass->getParticipant()->getUser()->getId() == $this->getUser()->getId() ) {
                        
                       

                        $iCanOnlyAccept =  $pass->getConfirmedMeetings();

                        // how many did i accept in this room ?
                        $confirmedIncomeRequest = $appointmentRequestRepository->findBy(['roomBtB'=>$appointmentRequest->getRoomBtB()->getId(),'receiver'=>$this->getUser()->getId(),'status'=>1]);
                        $confirmedSentRequest = $appointmentRequestRepository->findBy(['roomBtB'=>$appointmentRequest->getRoomBtB()->getId(),'sender'=>$this->getUser()->getId(),'status'=>1]);
                        

                        $iHaveThisMuchAccepted = sizeof($confirmedIncomeRequest) + sizeof($confirmedSentRequest);

                        if ( $iHaveThisMuchAccepted < $iCanOnlyAccept  ) {
                            $appointmentRequest->setStatus($status); 
        
                            $this->getDoctrine()->getManager()->flush();
                            return $this->redirectToRoute('networking_liste_of_invitation_route',[  'room'=>$appointmentRequest->getRoomBtB()->getId()]); 
                        }else{
        
                            $message="You reached the maximum number of appointments";
                           
                            if ($this->detectLanguage($session) =='fr' ) {
                               
                                $message = 'Vous avez atteint le nombre maximal des rendez-vous';
                            } 
        
                            return $this->redirectToRoute('networking_liste_of_invitation_route',[ 'error'=>$message, 'room'=>$appointmentRequest->getRoomBtB()->getId()]); 
                        }

                        
                    }
                }
            } 
            


            
        }else{
            $appointmentRequest->setStatus($status);  
            $this->getDoctrine()->getManager()->flush();


            return $this->redirectToRoute('networking_liste_of_invitation_route',['room'=>$appointmentRequest->getRoomBtB()->getId()]); 

        }

    }


            
    /**
     * @Route("/main-app/api/notifications", name="app_notification_route" )
     */
    public function get_user_notifications( ): JsonResponse {

        $notifications = $this->getUser()->getNotifications();  

        $notifs = [];
        foreach ($notifications as $key => $notif) {
            
            
                    array_push($notifs, 
                [ 
                    'title'=>$notif->getTitle(),
                    'content'=>$notif->getContent(),
                    'date'=>$notif->getDate(),
                    'seen'=>$notif->getSeen(),
                    'title'=>$notif->getTitle(),
                    'type'=>$notif->getType()
                    
                    
                
                ],);
            
           
        }
        
        return $this->json($notifs);

    }



    /**
     * @Route("/main-app/api/clear-notifications", name="app_clear_notification_route" )
     */
    public function app_clear_notification_route( ): JsonResponse {

        $notifications = $this->getUser()->getNotifications();  

       
        foreach ($notifications as $key => $notif) {
            
            if ($notif->getSeen() == 0) {
                 $notif->setSeen(1);
                 $this->getDoctrine()->getManager()->flush();

            }
           
        }
        
        return $this->json(["success"=>true]);

    }
 

 

    /**
     * @Route("/web-master/api/password-update-local/user-mail/{email}", name="local_password_update_route" )
     */
    public function local_password_update( $email , UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder ): JsonResponse {

       
        $user = $userRepository->findOneBy(['email'=>$email]);


        $password = $passwordEncoder->encodePassword($user, "super2022");
            
        $user->setPassword($password); 

        $this->getDoctrine()->getManager()->flush();
        
        return $this->json(["success"=>true]);

    }
 

 




    


       

 
}
