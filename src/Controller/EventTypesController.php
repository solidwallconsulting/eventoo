<?php

namespace App\Controller;

use App\Entity\EventTypes;
use App\Form\EventTypesType;
use App\Repository\EventTypesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/web-master/event-types")
 */
class EventTypesController extends AbstractController
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
     * @Route("/", name="event_types_index", methods={"GET"})
     */
    public function index(EventTypesRepository $eventTypesRepository): Response
    {
        return $this->render('event_types/index.html.twig', [
            'event_types' => $eventTypesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="event_types_new", methods={"GET","POST"})
     */
    public function new(Request $request, SessionInterface $session,  TranslatorInterface $translator): Response
    {
        $eventType = new EventTypes();
        $form = $this->createForm(EventTypesType::class, $eventType,['lng'=>$this->detectLanguage($session)]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($eventType);
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


            return $this->redirectToRoute('event_types_index', ['ok'=>$message], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('event_types/new.html.twig', [
            'event_type' => $eventType,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="event_types_show", methods={"GET"})
     */
    public function show(EventTypes $eventType): Response
    {
        return $this->render('event_types/show.html.twig', [
            'event_type' => $eventType,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="event_types_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EventTypes $eventType, SessionInterface $session, TranslatorInterface $translator): Response
    {
        $form = $this->createForm(EventTypesType::class, $eventType,['lng'=>$this->detectLanguage($session)]);
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

            return $this->redirectToRoute('event_types_index', ['ok'=>$message], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('event_types/edit.html.twig', [
            'event_type' => $eventType,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="event_types_delete", methods={"POST"})
     */
    public function delete(Request $request, EventTypes $eventType): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eventType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($eventType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('event_types_index', [], Response::HTTP_SEE_OTHER);
    }
}
