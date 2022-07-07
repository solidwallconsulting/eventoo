<?php

namespace App\Controller;

use App\Entity\BtBMeetingRoom;
use App\Entity\Participant;
use App\Repository\AppointmentRequestRepository;
use App\Repository\ParticipantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{



    /**
     * @Route("/main-app/networking/{room}", name="networking_route")
     */
    public function networking( BtBMeetingRoom $room, ParticipantRepository $participantRepository , AppointmentRequestRepository $appointmentRequestRepository): Response
    {

        // get event associated to the current user
        $user=$this->getUser(); 
        $event=$user->getParticipant()->getProfile()->getEvent();

        // we should get the participants associated in the same room !!!! 
        $participants = []; 



        $iCanOnlySend = 0;
        // invitations 
        $sentRequest = 0;

        // calculate my sent invitation in this room

        $sentInvitations = $appointmentRequestRepository->findBy(['roomBtB'=>$room->getId(),'sender'=>$this->getUser()->getId(),'event'=>$event ]);


        $sentRequest = sizeof($sentInvitations);  

        $incomeRequest = sizeof( $appointmentRequestRepository->findBy(['roomBtB'=>$room->getId(),'receiver'=>$this->getUser()->getId(),'event'=>$event ]));

        



        $confirmedRequest = 0; 
        $myLimitOfAppointments = 0; 
         

        $access = $room->getAccess();


        if ($access == 0) {
                

            $iCanOnlyAccept = $room->getNbrOfConfirmedMeetingPerMember();

            // how many did i accept in this room ?
            $confirmedIncomeRequest = $appointmentRequestRepository->findBy(['roomBtB'=>$room->getId(),'receiver'=>$this->getUser()->getId(),'status'=>1]);
            $confirmedSentRequest = $appointmentRequestRepository->findBy(['roomBtB'=>$room->getId(),'sender'=>$this->getUser()->getId(),'status'=>1]);
            

           
            $iHaveThisMuchAccepted = sizeof($confirmedIncomeRequest) + sizeof($confirmedSentRequest);

            $confirmedRequest = $iHaveThisMuchAccepted;
            $myLimitOfAppointments = $iCanOnlyAccept;




        } else if ( $access == 1 ) {
           
            $passes = $room->getRoomSessionAccesses();

            foreach ($passes as $key => $pass) {
                if ( $pass->getParticipant()->getUser()->getId() == $this->getUser()->getId() ) {
                    
                   

                    $iCanOnlyAccept =  $pass->getConfirmedMeetings();

                    // how many did i accept in this room ?
                    $confirmedIncomeRequest = $appointmentRequestRepository->findBy(['roomBtB'=>$room->getId(),'receiver'=>$this->getUser()->getId(),'status'=>1]);
                    $confirmedSentRequest = $appointmentRequestRepository->findBy(['roomBtB'=>$room->getId(),'sender'=>$this->getUser()->getId(),'status'=>1]);
                    

                    $iHaveThisMuchAccepted = sizeof($confirmedIncomeRequest) + sizeof($confirmedSentRequest);
                    $confirmedRequest = $iHaveThisMuchAccepted;
                    $myLimitOfAppointments = $iCanOnlyAccept;



                   
                    
                }
            }
        } 
        





        // first check if it's public room !! 0 is public

        if ($room->getAccess() == 0) { 

            $iCanOnlySend = $room->getMaximumInvitationNumber();

            // for every profile in the event

            $profiles = $event->getEventProfiles();

            foreach ($profiles as $k1 => $profile) {
                
                foreach ($profile->getParticipants() as $key => $participant) {
                   
                    if ($participant->getUser()->getId() != $this->getUser()->getId()) {
                        array_push($participants,$participant);

                    }
                }
            }
        }else{

            $accessS = $room->getRoomSessionAccesses();

            foreach ($accessS as $key => $access) {
                
               

                if ($access->getParticipant()->getUser()->getId() != $this->getUser()->getId()) {

                    array_push($participants,$access->getParticipant());

                }else{
                    $iCanOnlySend = $access->getInvitations();
                
                }

            } 

        }




        // my confirmed appointments

        $confirmedAppointments = [];
        $confirmedIncomeRequest = $appointmentRequestRepository->findBy(['roomBtB'=>$room->getId(),'receiver'=>$this->getUser()->getId(),'status'=>1]);
        $confirmedSentRequest = $appointmentRequestRepository->findBy(['roomBtB'=>$room->getId(),'sender'=>$this->getUser()->getId(),'status'=>1]);
        

 
        foreach ($confirmedIncomeRequest as $key => $request) {
            
            $alreadyInTheList = false;

            foreach ($confirmedAppointments as $key => $participant) {
                if ($participant->getId() == $request->getSender()->getParticipant()->getId() ) {
                    $alreadyInTheList = true;
                } 
            }

            if ($alreadyInTheList == false) {
                array_push($confirmedAppointments,$request->getSender()->getParticipant());
            }
        }


  
        foreach ($confirmedSentRequest as $key => $request) {
            
            $alreadyInTheList = false;

            foreach ($confirmedAppointments as $key => $participant) {
                if ($participant->getId() == $request->getReceiver()->getParticipant()->getId() ) {
                    $alreadyInTheList = true;


                   
                } 
            } 
 
            
            if ($alreadyInTheList == false) {
                array_push($confirmedAppointments,$request->getReceiver()->getParticipant());
            }
        }
 
        
        
        
        return $this->render('dashboard/networking.html.twig', [
            'room'=>$room,
            'event' => $event, 
            'participants'=>$participants,
            'sentRequest'=>$sentRequest,
            'incomeRequest'=>$incomeRequest,
            'confirmedRequest'=>sizeof($confirmedAppointments),
            'sentInvitations'=>$sentInvitations,
            'iCanOnlySend'=>$iCanOnlySend,
            'myLimitOfAppointments'=>$myLimitOfAppointments
        ]);
    }



  




    /**
     * @Route("/main-app/dashboard", name="app_dashboard_route")
     */
    public function index(ParticipantRepository $participantRepository): Response
    {
        // get event associated to the current user
        $user=$this->getUser();

        $event=$user->getParticipant()->getProfile()->getEvent();



        $participants = [];


        
                                 


        foreach ($event->getEventRooms() as $key => $room) {
            foreach ($room->getRoomProgramms() as $kr => $program) {
                foreach ($program->getParticipants() as $kp => $partcipant) {
                    
                    

                    $data = $participantRepository->findOneBy(['id'=>$partcipant]);

                    array_push($participants,$data);
                }

            }
        }
 
 
        return $this->render('dashboard/index.html.twig', [
            'event' => $event,
            'participants'=>$participants,
 
        ]);
    }





    

    /**
     * @Route("/main-app/networking/participant/{id}", name="app_networking_show_participant")
     */
    public function participant_show(Participant $partcipant): Response
    {
         
        return $this->render('dashboard/networking/participant.html.twig', [
             'participant'=>$partcipant,
             'event'=>$partcipant->getProfile()->getEvent()
 
        ]);
    }




 







    /**
     * @Route("/main-app/main-networking", name="app_dashboard_networking_business_route")
     */
    public function app_dashboard_networking_business_route(ParticipantRepository $participantRepository): Response
    {
        // get event associated to the current user
        $user=$this->getUser();

        $event=$user->getParticipant()->getProfile()->getEvent();
 
 
 
        return $this->render('dashboard/networking-main.html.twig', [
            'event' => $event
        ]);
    }




    /**
     * @Route("/main-app/networking/{room}/invitations-list", name="networking_liste_of_invitation_route")
     */
    public function networking_liste_of_invitation_route($filter = null, AppointmentRequestRepository $appointmentRequestRepository, BtBMeetingRoom $room ): Response
    {
        // get event associated to the current user
        $user=$this->getUser();

        $event=$user->getParticipant()->getProfile()->getEvent();
 
        $incomeRequest = $appointmentRequestRepository->findBy(['roomBtB'=>$room->getId(),'receiver'=>$this->getUser()->getId(),'event'=>$event ]);


 
 
 
        return $this->render('dashboard/networking/invitations.html.twig', [
            'event' => $event,
            'incomeRequest'=>$incomeRequest,
            'room'=>$room,
        ]);
    }



    /**
     * @Route("/main-app/networking/{room}/sent-invitations", name="networking_liste_of_sent_invitation_route")
     */
    public function networking_sent_invitation($filter = null, AppointmentRequestRepository $appointmentRequestRepository, BtBMeetingRoom $room ): Response
    {
        // get event associated to the current user
        $user=$this->getUser();

        $event=$user->getParticipant()->getProfile()->getEvent();
 
        $sentInvitations = $appointmentRequestRepository->findBy(['roomBtB'=>$room->getId(),'sender'=>$this->getUser()->getId(),'event'=>$event ]);


 
 
 
        return $this->render('dashboard/networking/sent-invitations.html.twig', [
            'event' => $event,
            'sentInvitations'=>$sentInvitations,
            'room'=>$room,
        ]);
    }




     /**
     * @Route("/main-app/networking/{room}/my-appointement", name="networking_my_appointement_route")
     */
    public function networking_my_appointement_route($filter = null, AppointmentRequestRepository $appointmentRequestRepository, BtBMeetingRoom $room ): Response
    {
        // get event associated to the current user
        $user=$this->getUser();

        $event=$user->getParticipant()->getProfile()->getEvent();
 
 
         
        $confirmedIncomeRequest = $appointmentRequestRepository->findBy(['roomBtB'=>$room->getId(),'receiver'=>$this->getUser()->getId(),'status'=>1]);
        $confirmedSentRequest = $appointmentRequestRepository->findBy(['roomBtB'=>$room->getId(),'sender'=>$this->getUser()->getId(),'status'=>1]);
        

        // participants from both lists;


        $participants = [];



        foreach ($confirmedIncomeRequest as $key => $request) {
            
            $alreadyInTheList = false;

            foreach ($participants as $key => $participant) {
                if ($participant->getId() == $request->getSender()->getParticipant()->getId() ) {
                    $alreadyInTheList = true;
                } 
            }

            if ($alreadyInTheList == false) {
                array_push($participants,$request->getSender()->getParticipant());
            }
        }


        foreach ($confirmedSentRequest as $key => $request) {
            
            $alreadyInTheList = false;

            foreach ($participants as $key => $participant) {
                if ($participant->getId() == $request->getReceiver()->getParticipant()->getId() ) {
                    $alreadyInTheList = true;
                } 
            }

            if ($alreadyInTheList == false) {
                array_push($participants,$request->getReceiver()->getParticipant());
            }
        }

 
 
        return $this->render('dashboard/networking/confirmed-appointments.html.twig', [
            'event' => $event, 
            'room'=>$room,
            'participants'=>$participants
        ]);
    }





    /**
     * @Route("/main-app/networking/confirmed-meetings/my-meetings", name="networking_my_meetings_route")
     */
    public function my_meetings(): Response
    {
     
        return $this->render('dashboard/my-meetings.html.twig', [
            
        ]);
    }






    


}
