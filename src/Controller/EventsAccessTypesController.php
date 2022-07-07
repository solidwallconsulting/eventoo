<?php

namespace App\Controller;

use App\Entity\EventsAccessTypes;
use App\Form\EventsAccessTypesType;
use App\Repository\EventsAccessTypesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/events/access/types")
 */
class EventsAccessTypesController extends AbstractController
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
     * @Route("/", name="events_access_types_index", methods={"GET"})
     */
    public function index(EventsAccessTypesRepository $eventsAccessTypesRepository): Response
    {
        return $this->render('events_access_types/index.html.twig', [
            'events_access_types' => $eventsAccessTypesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="events_access_types_new", methods={"GET","POST"})
     */
    public function new(Request $request, SessionInterface $session, TranslatorInterface $translator): Response
    {
        $eventsAccessType = new EventsAccessTypes();
        $form = $this->createForm(EventsAccessTypesType::class, $eventsAccessType,['lng'=>$this->detectLanguage($session)]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($eventsAccessType);
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

            return $this->redirectToRoute('events_access_types_index', ['ok'=>$message], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('events_access_types/new.html.twig', [
            'events_access_type' => $eventsAccessType,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="events_access_types_show", methods={"GET"})
     */
    public function show(EventsAccessTypes $eventsAccessType): Response
    {
        return $this->render('events_access_types/show.html.twig', [
            'events_access_type' => $eventsAccessType,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="events_access_types_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EventsAccessTypes $eventsAccessType, SessionInterface $session, TranslatorInterface $translator): Response
    {
        $form = $this->createForm(EventsAccessTypesType::class, $eventsAccessType,['lng'=>$this->detectLanguage($session)]);
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
            return $this->redirectToRoute('events_access_types_index', ['ok'=>$message], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('events_access_types/edit.html.twig', [
            'events_access_type' => $eventsAccessType,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="events_access_types_delete", methods={"POST"})
     */
    public function delete(Request $request, EventsAccessTypes $eventsAccessType): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eventsAccessType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($eventsAccessType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('events_access_types_index', [], Response::HTTP_SEE_OTHER);
    }
}
