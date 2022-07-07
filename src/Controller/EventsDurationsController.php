<?php

namespace App\Controller;

use App\Entity\EventsDurations;
use App\Form\EventsDurationsType;
use App\Repository\EventsDurationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/web-master/events/durations")
 */
class EventsDurationsController extends AbstractController
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
     * @Route("/", name="events_durations_index", methods={"GET"})
     */
    public function index(EventsDurationsRepository $eventsDurationsRepository): Response
    {
        return $this->render('events_durations/index.html.twig', [
            'events_durations' => $eventsDurationsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="events_durations_new", methods={"GET","POST"})
     */
    public function new(Request $request, SessionInterface $session, TranslatorInterface $translator): Response
    {
        $eventsDuration = new EventsDurations();
        $form = $this->createForm(EventsDurationsType::class, $eventsDuration,['lng'=>$this->detectLanguage($session)]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($eventsDuration);
            $entityManager->flush();


            $message = $translator->trans(
                'Ajouté avec succès',
                array(),
                'messages',
                $this->detectLanguage($session)
            );
            // TranslatorInterface $translator
            // ,SessionInterface $session
            // ,'ok'=>$message

            return $this->redirectToRoute('events_durations_index', ['ok'=>$message], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('events_durations/new.html.twig', [
            'events_duration' => $eventsDuration,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="events_durations_show", methods={"GET"})
     */
    public function show(EventsDurations $eventsDuration): Response
    {
        return $this->render('events_durations/show.html.twig', [
            'events_duration' => $eventsDuration,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="events_durations_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EventsDurations $eventsDuration, SessionInterface $session, TranslatorInterface $translator): Response
    {
        $form = $this->createForm(EventsDurationsType::class, $eventsDuration,['lng'=>$this->detectLanguage($session)]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $message = $translator->trans(
                'Donnée mise a jour avec succès',
                array(),
                'messages',
                $this->detectLanguage($session)
            );
            // TranslatorInterface $translator
            // ,SessionInterface $session
            // ,'ok'=>$message

            return $this->redirectToRoute('events_durations_index', ['ok'=>$message], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('events_durations/edit.html.twig', [
            'events_duration' => $eventsDuration,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="events_durations_delete", methods={"POST"})
     */
    public function delete(Request $request, EventsDurations $eventsDuration): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eventsDuration->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($eventsDuration);
            $entityManager->flush();
        }

        return $this->redirectToRoute('events_durations_index', [], Response::HTTP_SEE_OTHER);
    }
}
