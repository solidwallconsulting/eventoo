<?php

namespace App\Controller;

use App\Entity\EventsAccessibility;
use App\Form\EventsAccessibilityType;
use App\Repository\EventsAccessibilityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/web-master/events/accessibility")
 */
class EventsAccessibilityController extends AbstractController
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
     * @Route("/", name="events_accessibility_index", methods={"GET"})
     */
    public function index(EventsAccessibilityRepository $eventsAccessibilityRepository): Response
    {
        return $this->render('events_accessibility/index.html.twig', [
            'events_accessibilities' => $eventsAccessibilityRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="events_accessibility_new", methods={"GET","POST"})
     */
    public function new(Request $request, SessionInterface $session, TranslatorInterface $translator): Response
    {
        $eventsAccessibility = new EventsAccessibility();
        $form = $this->createForm(EventsAccessibilityType::class, $eventsAccessibility,['lng'=>$this->detectLanguage($session)]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($eventsAccessibility);
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


            return $this->redirectToRoute('events_accessibility_index', ['ok'=>$message], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('events_accessibility/new.html.twig', [
            'events_accessibility' => $eventsAccessibility,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="events_accessibility_show", methods={"GET"})
     */
    public function show(EventsAccessibility $eventsAccessibility): Response
    {
        return $this->render('events_accessibility/show.html.twig', [
            'events_accessibility' => $eventsAccessibility,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="events_accessibility_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EventsAccessibility $eventsAccessibility, SessionInterface $session, TranslatorInterface $translator): Response
    {
        $form = $this->createForm(EventsAccessibilityType::class, $eventsAccessibility,['lng'=>$this->detectLanguage($session)]);
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

            return $this->redirectToRoute('events_accessibility_index', ['ok'=>$message], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('events_accessibility/edit.html.twig', [
            'events_accessibility' => $eventsAccessibility,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="events_accessibility_delete", methods={"POST"})
     */
    public function delete(Request $request, EventsAccessibility $eventsAccessibility): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eventsAccessibility->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($eventsAccessibility);
            $entityManager->flush();
        }

        return $this->redirectToRoute('events_accessibility_index', [], Response::HTTP_SEE_OTHER);
    }
}
