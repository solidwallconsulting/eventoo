<?php

namespace App\Controller;

use App\Entity\EventAssociatedProfileFeilds;
use App\Form\EventAssociatedProfileFeildsType;
use App\Repository\EventAssociatedProfileFeildsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/event/associated/profile/feilds")
 */
class EventAssociatedProfileFeildsController extends AbstractController
{
    /**
     * @Route("/", name="event_associated_profile_feilds_index", methods={"GET"})
     */
    public function index(EventAssociatedProfileFeildsRepository $eventAssociatedProfileFeildsRepository): Response
    {
        return $this->render('event_associated_profile_feilds/index.html.twig', [
            'event_associated_profile_feilds' => $eventAssociatedProfileFeildsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="event_associated_profile_feilds_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $eventAssociatedProfileFeild = new EventAssociatedProfileFeilds();
        $form = $this->createForm(EventAssociatedProfileFeildsType::class, $eventAssociatedProfileFeild);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($eventAssociatedProfileFeild);
            $entityManager->flush();

            return $this->redirectToRoute('event_associated_profile_feilds_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('event_associated_profile_feilds/new.html.twig', [
            'event_associated_profile_feild' => $eventAssociatedProfileFeild,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="event_associated_profile_feilds_show", methods={"GET"})
     */
    public function show(EventAssociatedProfileFeilds $eventAssociatedProfileFeild): Response
    {
        return $this->render('event_associated_profile_feilds/show.html.twig', [
            'event_associated_profile_feild' => $eventAssociatedProfileFeild,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="event_associated_profile_feilds_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EventAssociatedProfileFeilds $eventAssociatedProfileFeild): Response
    {
        $form = $this->createForm(EventAssociatedProfileFeildsType::class, $eventAssociatedProfileFeild);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event_associated_profile_feilds_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('event_associated_profile_feilds/edit.html.twig', [
            'event_associated_profile_feild' => $eventAssociatedProfileFeild,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="event_associated_profile_feilds_delete", methods={"POST"})
     */
    public function delete(Request $request, EventAssociatedProfileFeilds $eventAssociatedProfileFeild): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eventAssociatedProfileFeild->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($eventAssociatedProfileFeild);
            $entityManager->flush();
        }

        return $this->redirectToRoute('event_associated_profile_feilds_index', [], Response::HTTP_SEE_OTHER);
    }
}
