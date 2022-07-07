<?php

namespace App\Controller;

use App\Entity\EventRooms;
use App\Form\EventRooms1Type;
use App\Repository\EventRoomsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/key/words")
 */
class KeyWordsController extends AbstractController
{
    /**
     * @Route("/", name="key_words_index", methods={"GET"})
     */
    public function index(EventRoomsRepository $eventRoomsRepository): Response
    {
        return $this->render('key_words/index.html.twig', [
            'event_rooms' => $eventRoomsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="key_words_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $eventRoom = new EventRooms();
        $form = $this->createForm(EventRooms1Type::class, $eventRoom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($eventRoom);
            $entityManager->flush();

            return $this->redirectToRoute('key_words_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('key_words/new.html.twig', [
            'event_room' => $eventRoom,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="key_words_show", methods={"GET"})
     */
    public function show(EventRooms $eventRoom): Response
    {
        return $this->render('key_words/show.html.twig', [
            'event_room' => $eventRoom,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="key_words_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EventRooms $eventRoom): Response
    {
        $form = $this->createForm(EventRooms1Type::class, $eventRoom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('key_words_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('key_words/edit.html.twig', [
            'event_room' => $eventRoom,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="key_words_delete", methods={"POST"})
     */
    public function delete(Request $request, EventRooms $eventRoom): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eventRoom->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($eventRoom);
            $entityManager->flush();
        }

        return $this->redirectToRoute('key_words_index', [], Response::HTTP_SEE_OTHER);
    }
}
