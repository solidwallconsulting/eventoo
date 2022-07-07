<?php

namespace App\Controller;

use App\Entity\EventStandMesures;
use App\Form\EventStandMesuresType;
use App\Repository\EventStandMesuresRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/web-master/event-stand-mesures")
 */
class EventStandMesuresController extends AbstractController
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
     * @Route("/", name="event_stand_mesures_index", methods={"GET"})
     */
    public function index(EventStandMesuresRepository $eventStandMesuresRepository): Response
    {
        return $this->render('event_stand_mesures/index.html.twig', [
            'event_stand_mesures' => $eventStandMesuresRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="event_stand_mesures_new", methods={"GET","POST"})
     */
    public function new(Request $request, SessionInterface $session): Response
    {
        $eventStandMesure = new EventStandMesures();
        $form = $this->createForm(EventStandMesuresType::class, $eventStandMesure,['lng'=>$this->detectLanguage($session)]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($eventStandMesure);
            $entityManager->flush();

            return $this->redirectToRoute('event_stand_mesures_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('event_stand_mesures/new.html.twig', [
            'event_stand_mesure' => $eventStandMesure,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="event_stand_mesures_show", methods={"GET"})
     */
    public function show(EventStandMesures $eventStandMesure): Response
    {
        return $this->render('event_stand_mesures/show.html.twig', [
            'event_stand_mesure' => $eventStandMesure,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="event_stand_mesures_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EventStandMesures $eventStandMesure, SessionInterface $session): Response
    {
        $form = $this->createForm(EventStandMesuresType::class, $eventStandMesure,['lng'=>$this->detectLanguage($session)]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event_stand_mesures_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('event_stand_mesures/edit.html.twig', [
            'event_stand_mesure' => $eventStandMesure,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="event_stand_mesures_delete", methods={"POST"})
     */
    public function delete(Request $request, EventStandMesures $eventStandMesure): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eventStandMesure->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($eventStandMesure);
            $entityManager->flush();
        }

        return $this->redirectToRoute('event_stand_mesures_index', [], Response::HTTP_SEE_OTHER);
    }
}
