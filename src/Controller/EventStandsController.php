<?php

namespace App\Controller;

use App\Entity\Events;
use App\Entity\EventStands;
use App\Form\EventStandsType;
use App\Repository\EventStandsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/common/event-stands")
 */
class EventStandsController extends AbstractController
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
     * @Route("/new/{id}", name="event_stands_new", methods={"GET","POST"})
     */
    public function new(Request $request, Events $event, SessionInterface $session): Response
    {
        $eventStand = new EventStands();
        $eventStand->setEvent($event);

        $participantsToChooseFrom = [];

        foreach ($event->getEventProfiles() as $key => $profile) {
             
            $tmp = [];

             // check if profile can have a stand
             $standConfigurations = $event->getStandConfigurations();

             $canHaveAStand = false;
             foreach ($standConfigurations as $key => $config) {
                 if ($config->getProfile()->getId() == $profile->getId()) {
                     $canHaveAStand = true; 
                 }
             }


             if ($canHaveAStand == true) {
                foreach ($profile->getParticipants() as $key => $p) {

               

                    array_push($participantsToChooseFrom, $p);
                }
             }

            

 
        }

        


        $form = $this->createForm(EventStandsType::class, $eventStand,['participants'=>$participantsToChooseFrom,'lng'=>$this->detectLanguage($session)]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($eventStand);
            $entityManager->flush();

            return $this->redirectToRoute('events_details', ['id'=>$event->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('event_stands/new.html.twig', [
            'event_stand' => $eventStand,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="event_stands_show", methods={"GET"})
     */
    public function show(EventStands $eventStand): Response
    {
        return $this->render('event_stands/show.html.twig', [
            'event_stand' => $eventStand,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="event_stands_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EventStands $eventStand, SessionInterface $session): Response
    {

        $participantsToChooseFrom = [];

        foreach ($eventStand->getEvent()-> getEventProfiles() as $key => $profile) {
             
            $tmp = [];

            foreach ($profile->getParticipants() as $key => $p) {
                array_push($participantsToChooseFrom, $p);
            }

 
        }



        $tmp = [];
        foreach ($eventStand->getTags() as $key => $value) {
            $tmp[$value]=$value;
        }

        $form = $this->createForm(EventStandsType::class, $eventStand,['tags'=>$tmp,'lng'=>$this->detectLanguage($session),'participants'=>$participantsToChooseFrom]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('events_details', ['id'=>$eventStand->getEvent()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('event_stands/edit.html.twig', [
            'event_stand' => $eventStand,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="event_stands_delete", methods={"POST"})
     */
    public function delete(Request $request, EventStands $eventStand): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eventStand->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($eventStand);
            $entityManager->flush();
        }

       //  return $this->redirectToRoute('event_stands_index', [], Response::HTTP_SEE_OTHER);
    }
}
