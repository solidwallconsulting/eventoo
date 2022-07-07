<?php

namespace App\Controller;

use App\Entity\EventProfiles;
use App\Form\EventProfilesType;
use App\Repository\ProfileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/common/event-profiles")
 */
class EventProfilesController extends AbstractController
{
    /**
     * @Route("/", name="event_profiles_index", methods={"GET"})
     */
    public function index(ProfileRepository $profileRepository): Response
    {
        return $this->render('event_profiles/index.html.twig', [
            'event_profiles' => $profileRepository->findAll(),
        ]);
    }
 

    /**
     * @Route("/{id}", name="event_profiles_show", methods={"GET"})
     */
    public function show(EventProfiles $eventProfile): Response
    {
        return $this->render('event_profiles/show.html.twig', [
            'event_profile' => $eventProfile,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="event_profiles_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EventProfiles $eventProfile): Response
    {
        $form = $this->createForm(EventProfilesType::class, $eventProfile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('events_details', ["id"=>$eventProfile->getEvent()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('event_profiles/edit.html.twig', [
            'event_profile' => $eventProfile,
            'event' => $eventProfile->getEvent(),
            
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="event_profiles_delete", methods={"POST"})
     */
    public function delete(Request $request, EventProfiles $eventProfile): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eventProfile->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($eventProfile);
            $entityManager->flush();
        }

        return $this->redirectToRoute('event_profiles_index', [], Response::HTTP_SEE_OTHER);
    }






    


}
