<?php

namespace App\Controller;

use App\Entity\BtBMeetingRoom;
use App\Entity\Events;
use App\Entity\RoomSessionAccess;
use App\Form\BtBMeetingRoomType;
use App\Repository\BtBMeetingRoomRepository;
use App\Repository\ParticipantRepository;
use App\Repository\RoomSessionAccessRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/common/b2b-meeting-rooms")
 */
class BtBMeetingRoomController extends AbstractController
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
     * @Route("/invitation-update", name="invitation_update-route")
     */
    public function FunctionName(Request $request, RoomSessionAccessRepository $roomSessionAccessRepository): JsonResponse
    {
        try {
            $data = $request->request;

            $access = $roomSessionAccessRepository->findOneBy(['id'=>$data->get('accessID')]);

            $access->setInvitations($data->get('newInviationsNumber'));
        $this->getDoctrine()->getManager()->flush();
        
        return $this->json(['success'=>true, 'invitations'=>$access->getInvitations()]);
        } catch (\Throwable $th) {
            return $this->json(['success'=>false]);
        }
    }


    /**
     * @Route("/confirmed-meeting-update", name="confirmed_meeting_route_update")
     */
    public function updateConfirmedMeeting(Request $request, RoomSessionAccessRepository $roomSessionAccessRepository): JsonResponse
    {
        try {
            $data = $request->request;

            $access = $roomSessionAccessRepository->findOneBy(['id'=>$data->get('accessID')]);

            $access->setConfirmedMeetings($data->get('confirmedMeeting'));
            $this->getDoctrine()->getManager()->flush();
        
        return $this->json(['success'=>true, 'confrimed_meeting'=>$access->getConfirmedMeetings()]);
        } catch (\Throwable $th) {
            return $this->json(['success'=>false]);
        }
    }


 

    /**
     * @Route("/new-room/room/{id}", name="bt_b_meeting_room_new", methods={"GET","POST"})
     */
    public function new(Request $request,Events $event, SessionInterface $session): Response
    {
        $btBMeetingRoom = new BtBMeetingRoom();
        $btBMeetingRoom->setEvent($event);
        $btBMeetingRoom->setInvitationsState(0);


        // how muchs session in this room
        
        


        $form = $this->createForm(BtBMeetingRoomType::class, $btBMeetingRoom,['lng'=>$this->detectLanguage($session)]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            
             
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($btBMeetingRoom);
            $entityManager->flush();

            return $this->redirectToRoute('events_details', ['id'=>$event->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bt_b_meeting_room/new.html.twig', [
            'bt_b_meeting_room' => $btBMeetingRoom,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/show-room/{id}", name="bt_b_meeting_room_show", methods={"GET","POST"})
     */
    public function show(BtBMeetingRoom $btBMeetingRoom , Request $request,ParticipantRepository $participantRepository, RoomSessionAccessRepository $roomSessionAccessRepository): Response
    {

         

        $method = $request->getMethod();

        if ($method == 'POST') {
            $participants = $request->request->get('participants');


            // first delete all access for current room session


            $list = $btBMeetingRoom->getRoomSessionAccesses();


           

            foreach ($list as $key => $old) {

                // 2       2 3    
                // check if participant id exist in the requested list
                $toBeRemoved = true;

                foreach ($participants as $key => $new) {

                    //dump($new , $old->getParticipant()->getId());

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

                $participant = $participantRepository->findOneBy(['id'=>$val]);
 
                $exists = false;

                $list = $btBMeetingRoom->getRoomSessionAccesses();

                foreach ($list as $key => $value) {
                    if ($value->getParticipant()->getId() == $participant->getId()) {
                        $exists = true;
                    }
                }

                if ($exists == false) {
                    # code...
                    $entity = new RoomSessionAccess(); 
                    $entity->setParticipant($participant);
                    $entity->setRoomBTB($btBMeetingRoom);
                    $entity->setInvitations($btBMeetingRoom->getMaximumInvitationNumber());
                    $entity->setConfirmedMeetings($btBMeetingRoom->getNbrOfConfirmedMeetingPerMember());
                    
                    

                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($entity);
                    $entityManager->flush();

                }


            }



        } 

        $tmp = $roomSessionAccessRepository->findBy(['roomBTB'=>$btBMeetingRoom->getId()]);

        return $this->render('bt_b_meeting_room/show.html.twig', [
            'bt_b_meeting_room' => $btBMeetingRoom ,
            'access'=>$tmp
        ]);
    }

    /**
     * @Route("/{id}/edit", name="bt_b_meeting_room_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, BtBMeetingRoom $btBMeetingRoom, SessionInterface $session): Response
    {
        $form = $this->createForm(BtBMeetingRoomType::class, $btBMeetingRoom,['lng'=>$this->detectLanguage($session)]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('events_details', ['id'=>$btBMeetingRoom->getEvent()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bt_b_meeting_room/edit.html.twig', [
            'bt_b_meeting_room' => $btBMeetingRoom,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="bt_b_meeting_room_delete", methods={"POST"})
     */
    public function delete(Request $request, BtBMeetingRoom $btBMeetingRoom): Response
    {
        if ($this->isCsrfTokenValid('delete'.$btBMeetingRoom->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($btBMeetingRoom);
            $entityManager->flush();
        }

        return $this->redirectToRoute('bt_b_meeting_room_index', [], Response::HTTP_SEE_OTHER);
    }
}
