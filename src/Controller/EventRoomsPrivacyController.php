<?php

namespace App\Controller;

use App\Entity\EventRoomsPrivacy;
use App\Form\EventRoomsPrivacyType;
use App\Repository\EventRoomsPrivacyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/web-master/event-rooms-privacy")
 */
class EventRoomsPrivacyController extends AbstractController
{
    /**
     * @Route("/", name="event_rooms_privacy_index", methods={"GET"})
     */
    public function index(EventRoomsPrivacyRepository $eventRoomsPrivacyRepository): Response
    {
        return $this->render('event_rooms_privacy/index.html.twig', [
            'event_rooms_privacies' => $eventRoomsPrivacyRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="event_rooms_privacy_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $eventRoomsPrivacy = new EventRoomsPrivacy();
        $form = $this->createForm(EventRoomsPrivacyType::class, $eventRoomsPrivacy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($eventRoomsPrivacy);
            $entityManager->flush();

            return $this->redirectToRoute('event_rooms_privacy_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('event_rooms_privacy/new.html.twig', [
            'event_rooms_privacy' => $eventRoomsPrivacy,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="event_rooms_privacy_show", methods={"GET"})
     */
    public function show(EventRoomsPrivacy $eventRoomsPrivacy): Response
    {
        return $this->render('event_rooms_privacy/show.html.twig', [
            'event_rooms_privacy' => $eventRoomsPrivacy,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="event_rooms_privacy_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EventRoomsPrivacy $eventRoomsPrivacy): Response
    {
        $form = $this->createForm(EventRoomsPrivacyType::class, $eventRoomsPrivacy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event_rooms_privacy_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('event_rooms_privacy/edit.html.twig', [
            'event_rooms_privacy' => $eventRoomsPrivacy,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="event_rooms_privacy_delete", methods={"POST"})
     */
    public function delete(Request $request, EventRoomsPrivacy $eventRoomsPrivacy): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eventRoomsPrivacy->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($eventRoomsPrivacy);
            $entityManager->flush();
        }

        return $this->redirectToRoute('event_rooms_privacy_index', [], Response::HTTP_SEE_OTHER);
    }
}
