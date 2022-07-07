<?php

namespace App\Controller;

use App\Entity\BtBMeetingRoom;
use App\Entity\MeetingSessions;
use App\Entity\Participant;
use App\Entity\RoomSessionAccess;
use App\Entity\SessionMeetings;
use App\Form\MeetingSessionsType;
use App\Repository\AppointmentRequestRepository;
use App\Repository\MeetingSessionsRepository;
use App\Repository\ParticipantRepository;
use App\Repository\RoomSessionAccessRepository;
use App\Repository\SessionMeetingsRepository;
use DateTime;
use DateTimeZone;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/common/meeting-sessions")
 */
class MeetingSessionsController extends AbstractController
{

    public function detectLanguage(SessionInterface $session): ?string
    {

        $locale = $session->get('lng');

        if ($locale == null) {

            return 'fr';
        } else {
            return $session->get('lng');
        }
    }



    /**
     * @Route("/room/{id}", name="meeting_sessions_index", methods={"GET","POST"})
     */
    public function index(TranslatorInterface $translator, Request $request, SessionMeetingsRepository $sessionMeetingsRepository, AppointmentRequestRepository $appointmentRequestRepository, MeetingSessionsRepository $meetingSessionsRepository, BtBMeetingRoom $room): Response
    {

        $participants = [];
        $event = $room->getEvent();

        // first check if it's public room !! 0 is public

        if ($room->getAccess() == 0) {




            $profiles = $event->getEventProfiles();

            foreach ($profiles as $k1 => $profile) {

                foreach ($profile->getParticipants() as $key => $participant) {
                    array_push($participants, $participant);
                }
            }
        } else {


            $accessS = $room->getRoomSessionAccesses();

            foreach ($accessS as $key => $access) {


                if ($access->getParticipant()->getUser()->getId() != $this->getUser()->getId()) {

                    array_push($participants, $access->getParticipant());
                }
            }
        }



        $errorGeneration = null;


        if ($request->getMethod() == 'POST') {

            if ($request->request->get('toggle_state')) {
                $room->setInvitationsState( $room->getInvitationsState() == 0 ? 1 : 0 );
                $this->getDoctrine()->getManager()->flush();

            }
        }




        if ($request->getMethod() == 'POST') {

            if ($request->request->get('generate-meetings')) {

               try {
                    // participants who have a confirmed meetings









                foreach ($participants as $key => $p) {
                    $confirmedAppointments = [];
                    $confirmedIncomeRequest = []; //   $appointmentRequestRepository->findBy(['roomBtB'=>$room->getId(),'receiver'=>$p->getUser()->getId(),'status'=>1]);
                    $confirmedSentRequest = $appointmentRequestRepository->findBy(['roomBtB' => $room->getId(), 'sender' => $p->getUser()->getId(), 'status' => 1]);


                    foreach ($confirmedSentRequest as $key => $request) {

                        $alreadyInTheList = false;

                        foreach ($confirmedAppointments as $key => $participant) {
                            if ($participant->getId() == $request->getReceiver()->getParticipant()->getId()) {
                                $alreadyInTheList = true;
                            }
                        }


                        if ($alreadyInTheList == false) {
                            array_push($confirmedAppointments, $request->getReceiver()->getParticipant());
                        }
                    }



                    // income  !!!!!!!

                    foreach ($confirmedIncomeRequest as $key => $request) {

                        $alreadyInTheList = false;

                        foreach ($confirmedAppointments as $key => $participant) {
                            if ($participant->getId() == $request->getSender()->getParticipant()->getId()) {
                                $alreadyInTheList = true;
                            }
                        }

                        if ($alreadyInTheList == false) {
                            array_push($confirmedAppointments, $request->getSender()->getParticipant());
                        }
                    }





                    // avant de commencer ont doit supprimer tt les meetings !!



                    // delete old before new

                    $sessions = $room->getMeetingSessions();


                    foreach ($sessions as $key => $session) {

                        $meetings = $session->getSessionMeetings();

                        foreach ($meetings as $key => $meet) {

                            $entityManager = $this->getDoctrine()->getManager();
                            $entityManager->remove($meet);
                            $entityManager->flush();
                        }
                    }





                    $sessions = $room->getMeetingSessions();
                    $sessionIterationCount = 0;


                    // first meeting start at !!
                    $date = $sessions[$sessionIterationCount]->getDateAndTime();
                    $endDate = $sessions[$sessionIterationCount]->getEndDateTime();

                    $firstMeetinfTimeSeconds = $date->format('U');
                    $intervalMeeting = $sessions[$sessionIterationCount]->getMinutesPerRDV() * 60;



                    $count = 0;
                    $iteration = 0;
                    $maxIteration = sizeof($confirmedAppointments);


                    /**
                     * if ($p->getId()==42) {
                     *   dump($confirmedAppointments);
                    *}

                     */

                    $outOfSessionsResources = false;


                    while ($iteration < $maxIteration && $outOfSessionsResources == false) {




                        $seconds = $firstMeetinfTimeSeconds + ($intervalMeeting * $count);
                        $nextMeetingDate = new DateTime("@$seconds");
                        $nextMeetingDate->setTimezone(new DateTimeZone(date_default_timezone_get()));

                        if ($nextMeetingDate->format('U') >= $endDate->format('U')) {


                            // check if theres a next session !!
                            $sessionIterationCount++;

                            $count = 0;

                            if ($sessions[$sessionIterationCount] == null) {
                                $outOfSessionsResources = true;
                            }
                        }





                        if ($outOfSessionsResources == false) {


                            $date = $sessions[$sessionIterationCount]->getDateAndTime();
                            $endDate = $sessions[$sessionIterationCount]->getEndDateTime();

                            $firstMeetinfTimeSeconds = $date->format('U');
                            $intervalMeeting = $sessions[$sessionIterationCount]->getMinutesPerRDV() * 60;

                            $seconds = $firstMeetinfTimeSeconds + ($intervalMeeting * $count);


                            $nextMeetingDate = new DateTime("@$seconds");
                            $nextMeetingDate->setTimezone(new DateTimeZone(date_default_timezone_get()));


                            // if there's anybody are going to meet second at this time ???

                            $tmpCheck  = $sessionMeetingsRepository->findBy(['startDate' => $nextMeetingDate, 'second' => $confirmedAppointments[$iteration]->getId(), 'session' => $sessions[$sessionIterationCount]->getId()]);

                            $tmpCheck2  = $sessionMeetingsRepository->findBy(['startDate' => $nextMeetingDate, 'main' => $confirmedAppointments[$iteration]->getId(), 'session' => $sessions[$sessionIterationCount]->getId()]);

                            $tmpCheck3  = $sessionMeetingsRepository->findBy(['startDate' => $nextMeetingDate, 'main' => $p->getId(), 'session' => $sessions[$sessionIterationCount]->getId()]);

                            $tmpCheck4  = $sessionMeetingsRepository->findBy(['startDate' => $nextMeetingDate, 'second' => $p->getId(), 'session' => $sessions[$sessionIterationCount]->getId()]);

                            


                            if (sizeof($tmpCheck) != 0 || sizeof($tmpCheck2) != 0 || sizeof($tmpCheck3) != 0 || sizeof($tmpCheck4) != 0 ) {


                                $foundANewDate = false;

                                $tmpCount = 0; 

                                while ($foundANewDate == false) {

                                    $seconds = $firstMeetinfTimeSeconds + ($intervalMeeting * $tmpCount);
                                    $nextMeetingDate = new DateTime("@$seconds");
                                    $nextMeetingDate->setTimezone(new DateTimeZone(date_default_timezone_get()));

                                    $tmpCheck  = $sessionMeetingsRepository->findBy(['startDate' => $nextMeetingDate, 'second' => $confirmedAppointments[$iteration]->getId(), 'session' => $sessions[$sessionIterationCount]->getId()]);

                                    $tmpCheck2  = $sessionMeetingsRepository->findBy(['startDate' => $nextMeetingDate, 'main' => $confirmedAppointments[$iteration]->getId(), 'session' => $sessions[$sessionIterationCount]->getId()]);

                                    $tmpCheck3  = $sessionMeetingsRepository->findBy(['startDate' => $nextMeetingDate, 'main' => $p->getId(), 'session' => $sessions[$sessionIterationCount]->getId()]);

                                    $tmpCheck4  = $sessionMeetingsRepository->findBy(['startDate' => $nextMeetingDate, 'second' => $p->getId(), 'session' => $sessions[$sessionIterationCount]->getId()]);

                                    

                                    if (sizeof($tmpCheck) == 0 && sizeof($tmpCheck2) == 0 && sizeof($tmpCheck3) == 0 && sizeof($tmpCheck4) == 0  ) {
                                        $foundANewDate = true; 
                                    }

                                    $tmpCount++;
                                }
                            }


                            $uniqueID = uniqid("room_" . $room->getId());

                            $mainSessionMeeting = new SessionMeetings();

                            $mainSessionMeeting->setMain($p);
                            $mainSessionMeeting->setSecond($confirmedAppointments[$iteration]);
                            $mainSessionMeeting->setStartDate($nextMeetingDate);
                            $mainSessionMeeting->setSession($sessions[$sessionIterationCount]);
                            $mainSessionMeeting->setOrderCreation(1);
                            $mainSessionMeeting->setUniqueID($uniqueID);
                            $mainSessionMeeting->setPresence(0);
                            $mainSessionMeeting->setRealisation(0);
                            





                            $secondSessionMeeting = new SessionMeetings();

                            $secondSessionMeeting->setMain($confirmedAppointments[$iteration]);
                            $secondSessionMeeting->setSecond($p);
                            $secondSessionMeeting->setStartDate($nextMeetingDate);
                            $secondSessionMeeting->setSession($sessions[$sessionIterationCount]);
                            $secondSessionMeeting->setOrderCreation(2);
                            $secondSessionMeeting->setUniqueID($uniqueID);
                            $secondSessionMeeting->setPresence(0);
                            $secondSessionMeeting->setRealisation(0);



                            $entityManager = $this->getDoctrine()->getManager();
                            $entityManager->persist($mainSessionMeeting);
                            $entityManager->persist($secondSessionMeeting);

                            $entityManager->flush();



                            $iteration++;
                            $count++;
                        }
                    }
                }



                // meeting are done now we hundle tables

                // get meeting per time section  for every session //



                
                $sessions = $room->getMeetingSessions();
                $meetingThatDontHaveTable = [];
                $total = 0;

                foreach ($sessions as $key => $session) {

                    $numberOfMeetingsPerSections = $session->getNbrTablesPerSession();



                    $date = $session->getDateAndTime();
                    $endDate = $session->getEndDateTime();

                    $firstMeetinfTimeSeconds = $date->format('U');  // in seconds
                    $intervalMeeting = $session->getMinutesPerRDV() * 60;




                    $count = 0;
                    $done = false;

                    


                    while ($done == false) {

                        
                        

                        $seconds = $firstMeetinfTimeSeconds + ($intervalMeeting * $count);
                        $nextMeetingDate = new DateTime("@$seconds");
                        $nextMeetingDate->setTimezone(new DateTimeZone(date_default_timezone_get()));



                        // how many meeting in this date ???

                        $tmpREQ = $sessionMeetingsRepository->findBy(['orderCreation' => 1, 'startDate' => $nextMeetingDate]);



                        $meetingsInThisDate = [];

                        foreach ($tmpREQ as $key => $tm) {
                            
                            // is this meeting belongs to one of our events ?
                            $belonge = false;

                            $sID = $tm->getSession()->getId();

                            foreach ($sessions as $key => $s) {
                                if ($s->getId() == $sID) {
                                    $belonge = true;
                                }
                            }


                            if ($belonge ) {
                                array_push($meetingsInThisDate,$tm);
                            }
                            
                        }

                        

                        // now w place meeting on diffrent tables
                        $nbrMeetingsInThisSection  = sizeof($meetingsInThisDate); 


                        //dump($nextMeetingDate,sizeof($meetingsInThisDate));

                        $total+=sizeof($meetingsInThisDate);

                        dump($meetingsInThisDate);


                        $tableNumber = 1;

                        for ($i = 0; $i < $nbrMeetingsInThisSection; $i++) {

 
                            if ($i < $numberOfMeetingsPerSections) {
                                $meeting = $meetingsInThisDate[$i];

                                $meeting->setTableNumber($tableNumber);
                                // find second order
                                $secondOrder = $sessionMeetingsRepository->findOneBy(['orderCreation' => 2, 'uniqueID' => $meeting->getUniqueID()]);
                                $secondOrder->setTableNumber($tableNumber);

                                $this->getDoctrine()->getManager()->flush();

                                $tableNumber++;
                            } else {
                                array_push($meetingThatDontHaveTable, $meetingsInThisDate[$i]);
                            }
                        }
 
                        $count++;

                        if ($nextMeetingDate > $endDate ) {
                            $done = true;
                        }
                        
                        
                    }


                  
                }


                dump($total);
                
                dump($meetingThatDontHaveTable);

                 


                /*
                                // another check for tables

                $meetingThatDontHaveTable = [];

                //dump($room->getMeetingSessions());

                foreach ($room->getMeetingSessions() as $key => $s) {
                    
                    $notableMeetings = $sessionMeetingsRepository->findBy(['orderCreation' => 1,'tableNumber'=>null,'session'=>$s->getId()]);

                   // dump($notableMeetings);

                    foreach ($notableMeetings as $key => $m) {
                        array_push($meetingThatDontHaveTable,$m);
                    }

                } */




            


                $sessionINDEX=0; 
    
                for ($meetingINDEX=0; $meetingINDEX < sizeof($meetingThatDontHaveTable) ; $meetingINDEX++) { 
                    
                    $tmpMeeting = $meetingThatDontHaveTable[$meetingINDEX];

                     

                    $weDidFoundTable = false;

                    $allSessionsDONE = false;
 
 
                    $correctionCOUNT = 0;
                    while (  $weDidFoundTable == false && $allSessionsDONE == false ) {

                        $session = $sessions[$sessionINDEX]; 

                        //dump($sessionINDEX);
    
                        $date = $session->getDateAndTime();
                        $endDate = $session->getEndDateTime();
                        $firstMeetinfTimeSeconds = $date->format('U');  // in seconds
                        $intervalMeeting = $session->getMinutesPerRDV() * 60;
    
    
                        $seconds = $firstMeetinfTimeSeconds + ($intervalMeeting * $correctionCOUNT);
                        $nextMeetingDate = new DateTime("@$seconds");
                        $nextMeetingDate->setTimezone(new DateTimeZone(date_default_timezone_get()));

                        $avaibleTables = $session->getNbrTablesPerSession(); // 20

                        for ($tableNumber=0; $tableNumber < $avaibleTables; $tableNumber++) {
                            // check if this table is available
    
    
                            $check = $sessionMeetingsRepository->findOneBy(['tableNumber' => ($tableNumber + 1),'orderCreation'=>1, 'session' => $session->getId(), 'startDate' => $nextMeetingDate]);
        
                            if ($check == null) {

                                

                                // but check if this user already have a meeting in this date 

                                $check2 = null;

                                $persone1 = $tmpMeeting->getMain();
                                $persone2 = $tmpMeeting->getSecond();
                                

                                $check2 = $sessionMeetingsRepository->findOneBy(['main' => $persone1->getId() , 'startDate' => $nextMeetingDate]);
                                $check3 = $sessionMeetingsRepository->findOneBy(['main' => $persone2->getId() , 'startDate' => $nextMeetingDate]);
        


                                if ($check2 == null && $check3 == null) {
                                    // check if the date is in the session range
 
                                        $weDidFoundTable = true;
                                        // done !!!
                                        $tmpMeeting->setStartDate($nextMeetingDate);
                                        $tmpMeeting->setTableNumber(($tableNumber + 1));
            
                                        $secondOrderMeeting = $sessionMeetingsRepository->findOneBy(['orderCreation' => 2, 'uniqueID' => $tmpMeeting->getUniqueID()]);
                                        $secondOrderMeeting->setTableNumber(($tableNumber + 1));
                                        $secondOrderMeeting->setStartDate($nextMeetingDate);

                                        $this->getDoctrine()->getManager()->flush();
                                        break;
                                        
                                }
                                
    
                               
                            }
    
                        }

                        // check if we found a table 
                        if ($tmpMeeting->getTableNumber() == null) {
                          // do we still have time sections ??


                            if ($nextMeetingDate->format('U') <= $endDate->format('U')) {
                                $correctionCOUNT++;
                            } else{
                                // :/ maybe we sould jumt to the next session
                                
                                // do we still have sessions .?
                                $sessionINDEX++;
                                
                                if ($sessions[$sessionINDEX] == null) {
                                    # code...
                                    $allSessionsDONE = true;
                                }else{
                                   
                                     $session = $sessions[$sessionINDEX];
                                     $correctionCOUNT = 0;
                                
                                }
                            }


                           
                        }else{
                            $weDidFoundTable = true;
                        }



                    }
                    
                
                }





               } catch (\Throwable $error) {

                 
                   /* $errorGeneration = $translator->trans(
                        'Les ressources de cet événement ne vous permettent pas de générer des réunions',
                        array(),
                        'messages',
                        $this->detectLanguage($session)
                    );*/
                    

                    // delete all generated values

                    $sessions = $room->getMeetingSessions(); 
                    foreach ($sessions as $key => $session) { 
                        $meetings = $session->getSessionMeetings(); 
                        foreach ($meetings as $key => $meet) { 
                            $entityManager = $this->getDoctrine()->getManager();
                            $entityManager->remove($meet);
                            $entityManager->flush();
                        }
                    }

               }
            }
        }




        

 


        return $this->render('meeting_sessions/index.html.twig', [
            'meeting_sessions' => $meetingSessionsRepository->findBy(['room' => $room]),
            'meeting_session' => $room,
            'room' => $room,
            
            'participants' => $participants,
            'error_meetings'=>$errorGeneration
        ]);
    }




    /**
     * @Route("/participant-printer/room/{room}/participant/{participant}", name="participant_printer_route", methods={"GET","POST"})
     */
    public function printer(Participant $participant, BtBMeetingRoom $room): Response
    {
        

        return $this->renderForm('meeting_sessions/printer.html.twig', [
            'room'=>$room,
            'participant'=>$participant,
            
        ]);
    }



    /**
     * @Route("/participant-csv/room/{room}/participant/{participant}", name="participant_csv_route", methods={"GET","POST"})
     */
    public function csv(Participant $participant, BtBMeetingRoom $room, SessionMeetingsRepository $sessionMeetingsRepository)
    {

        $list = array(
            ["Date",	"Nom et prénom", 	"Email",	"Télephone",	"Table",	"Session"],

             
        );


        // get participant meetings

        $meetings = $sessionMeetingsRepository->findBy(['main'=>$participant->getId()]);


        foreach ($meetings as $key => $meet) {
            array_push($list,array( $meet->getStartDate()->format('Y-m-d H:i:s'),$meet->getSecond()->getUser()->getFirstname().' '.$meet->getSecond()->getUser()->getLastname(),$meet->getSecond()->getUser()->getEmail(),$meet->getSecond()->getUser()->getPhone(),'Table N° : '.$meet->getTableNumber(),$meet->getSession()->getName() ));
        }


           
        $id = uniqid();

        // Open a file in write mode ('w')
        $fp = fopen('csvs/'.$id.'.csv', 'w');
          
        // Loop through file pointer and a line
        foreach ($list as $fields) {
            fputcsv($fp, $fields);
        }
          
        fclose($fp);

 
        $link='/csvs/'.$id.'.csv';

        
        return $this->redirect ($link, Response::HTTP_SEE_OTHER);

                
    }







    /**
     * @Route("/new/room/{id}", name="meeting_sessions_new", methods={"GET","POST"})
     */
    public function new(Request $request, SessionInterface $session, BtBMeetingRoom $room): Response
    {
        $meetingSession = new MeetingSessions();
        $meetingSession->setRoom($room);

        // how many session in this room ?

        $nbrSession = sizeof($room->getMeetingSessions());

        $name = '';

        if ($this->detectLanguage($session) == 'fr') {
            $name = 'Séance numéro ' . ($nbrSession + 1) . ' : ' . $room->getTheme();
        } else {
            $name = 'Session number ' . ($nbrSession + 1) . ' : ' . $room->getTheme();
        }

        $meetingSession->setName($name);


        $form = $this->createForm(MeetingSessionsType::class, $meetingSession, ['lng' => $this->detectLanguage($session)]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($meetingSession);
            $entityManager->flush();

            return $this->redirectToRoute('meeting_sessions_index', ['id' => $room->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('meeting_sessions/new.html.twig', [
            'meeting_session' => $meetingSession,
            'form' => $form,
        ]);
    }










    /**
     * @Route("/{id}", name="meeting_sessions_show", methods={"GET","POST"})
     */
    public function show(RoomSessionAccessRepository $roomSessionAccessRepository, MeetingSessions $meetingSession, Request $request, ParticipantRepository $participantRepository): Response
    {
        $method = $request->getMethod();

        if ($method == 'POST') {
            $participants = $request->request->get('participants');


            // first delete all access for current room session


            $list = $meetingSession->getRoomSessionAccesses();




            foreach ($list as $key => $old) {

                // 2       2 3    
                // check if participant id exist in the requested list
                $toBeRemoved = true;

                foreach ($participants as $key => $new) {

                   // dump($new, $old->getParticipant()->getId());

                    if ($new == $old->getParticipant()->getId()) {
                        $toBeRemoved = false;
                    }
                }


                if ($toBeRemoved == true) {
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->remove($old);
                    $entityManager->flush();
                }
            }







            foreach ($participants as $key => $val) {

                $participant = $participantRepository->findOneBy(['id' => $val]);

                $exists = false;

                $list = $meetingSession->getRoomSessionAccesses();

                foreach ($list as $key => $value) {
                    if ($value->getParticipant()->getId() == $participant->getId()) {
                        $exists = true;
                    }
                }

                if ($exists == false) {
                    # code...
                    $entity = new RoomSessionAccess();
                    $entity->setParticipant($participant);

                    $entity->setInvitations($meetingSession->getRoom()->getMaximumInvitationNumber());
                    $entity->setConfirmedMeetings($meetingSession->getRoom()->getNbrOfConfirmedMeetingPerMember());



                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($entity);
                    $entityManager->flush();
                }
            }
        }

        $tmp = $roomSessionAccessRepository->findBy(['session' => $meetingSession]);




        return $this->render('meeting_sessions/show.html.twig', [
            'meeting_session' => $meetingSession,
            'access' => $tmp
        ]);
    }

    /**
     * @Route("/{id}/edit", name="meeting_sessions_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, MeetingSessions $meetingSession, SessionInterface $session): Response
    {
        $form = $this->createForm(MeetingSessionsType::class, $meetingSession, ['lng' => $this->detectLanguage($session)]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('meeting_sessions_index', ['id' => $meetingSession->getRoom()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('meeting_sessions/edit.html.twig', [
            'meeting_session' => $meetingSession,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="meeting_sessions_delete", methods={"POST"})
     */
    public function delete(Request $request, MeetingSessions $meetingSession): Response
    {
        if ($this->isCsrfTokenValid('delete' . $meetingSession->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($meetingSession);
            $entityManager->flush();
        }

        return $this->redirectToRoute('meeting_sessions_index', [], Response::HTTP_SEE_OTHER);
    }






    /**
     * @Route("/update_session_meeting_realisation/{id}/{status}", name="update_session_meeting_realisation", methods={"POST"})
     */
    public function update_session_meeting_realisation(Request $request, SessionMeetings $sessionMeetings, $status): JsonResponse
    {
        
        $sessionMeetings->setRealisation($status);
        $this->getDoctrine()->getManager()->flush();

        return $this->json(['success'=>true]);
      
    }


    /**
     * @Route("/update_session_meeting_presence/{id}/{status}", name="update_session_meeting_presence", methods={"POST"})
     */
    public function update_session_meeting_presence(Request $request, SessionMeetings $sessionMeetings, $status): JsonResponse
    {
        
        $sessionMeetings->setPresence($status);
        $this->getDoctrine()->getManager()->flush();
        
        return $this->json(['success'=>true]);
      
    }





}
