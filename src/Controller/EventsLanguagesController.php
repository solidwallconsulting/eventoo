<?php

namespace App\Controller;

use App\Entity\EventsLanguages;
use App\Form\EventsLanguagesType;
use App\Repository\EventsLanguagesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/web-master/events-languages")
 */
class EventsLanguagesController extends AbstractController
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
     * @Route("/", name="events_languages_index", methods={"GET"})
     */
    public function index(EventsLanguagesRepository $eventsLanguagesRepository): Response
    {
        return $this->render('events_languages/index.html.twig', [
            'events_languages' => $eventsLanguagesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="events_languages_new", methods={"GET","POST"})
     */
    public function new(Request $request, TranslatorInterface $translator,SessionInterface $session): Response
    {
        $eventsLanguage = new EventsLanguages();
        $form = $this->createForm(EventsLanguagesType::class, $eventsLanguage,['lng'=>$this->detectLanguage($session)]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($eventsLanguage);
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

            return $this->redirectToRoute('events_languages_index', ['ok'=>$message], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('events_languages/new.html.twig', [
            'events_language' => $eventsLanguage,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="events_languages_show", methods={"GET"})
     */
    public function show(EventsLanguages $eventsLanguage): Response
    {
        return $this->render('events_languages/show.html.twig', [
            'events_language' => $eventsLanguage,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="events_languages_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EventsLanguages $eventsLanguage,TranslatorInterface $translator,SessionInterface $session): Response
    {
        $form = $this->createForm(EventsLanguagesType::class, $eventsLanguage);
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

            return $this->redirectToRoute('events_languages_index', ['ok'=>$message], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('events_languages/edit.html.twig', [
            'events_language' => $eventsLanguage,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="events_languages_delete", methods={"POST"})
     */
    public function delete(Request $request, EventsLanguages $eventsLanguage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eventsLanguage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($eventsLanguage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('events_languages_index', [], Response::HTTP_SEE_OTHER);
    }
}
