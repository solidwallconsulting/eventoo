<?php

namespace App\Controller;

use App\Entity\EventProfileFeilds;
use App\Entity\EventProfileFeildValue;
use App\Form\EventProfileFeildValueType;
use App\Repository\EventProfileFeildValueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/common/event/profile-feild-values")
 */
class EventProfileFeildValueController extends AbstractController
{



    /**
     * @Route("/list/{id}", name="event_profile_feild_value_index", methods={"GET"})
     */
    public function index( EventProfileFeilds $eventProfileFeilds): Response
    {
        return $this->render('event_profile_feild_value/index.html.twig', [
            'event_profile_feild_values' => $eventProfileFeilds->getEventProfileFeildValues(),
            'eventProfileFeilds'=>$eventProfileFeilds,
            'event'=>$eventProfileFeilds->getEvent()
        ]);
    }

    /**
     * @Route("/new/{id}", name="event_profile_feild_value_new", methods={"GET","POST"})
     */
    public function new(Request $request, EventProfileFeilds $eventProfileFeilds): Response
    {
        $eventProfileFeildValue = new EventProfileFeildValue();
        $form = $this->createForm(EventProfileFeildValueType::class, $eventProfileFeildValue);
        $form->handleRequest($request);
        
        $eventProfileFeildValue->setEventFeild($eventProfileFeilds);
        
        if ($form->isSubmitted() && $form->isValid()) {

            

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($eventProfileFeildValue);
            $entityManager->flush();

            return $this->redirectToRoute('event_profile_feild_value_index', ['id'=>$eventProfileFeilds->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('event_profile_feild_value/new.html.twig', [
            'event_profile_feild_value' => $eventProfileFeildValue,
            'form' => $form,
            'eventProfileFeilds'=>$eventProfileFeilds,
            'event'=>$eventProfileFeilds->getEvent()

        ]);
    }

    /**
     * @Route("/{id}", name="event_profile_feild_value_show", methods={"GET"})
     */
    public function show(EventProfileFeildValue $eventProfileFeildValue): Response
    {
        return $this->render('event_profile_feild_value/show.html.twig', [
            'event_profile_feild_value' => $eventProfileFeildValue,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="event_profile_feild_value_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EventProfileFeildValue $eventProfileFeildValue): Response
    {
        $form = $this->createForm(EventProfileFeildValueType::class, $eventProfileFeildValue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event_profile_feild_value_index', ['id'=>$eventProfileFeildValue->getEventFeild()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('event_profile_feild_value/edit.html.twig', [
            'event_profile_feild_value' => $eventProfileFeildValue,
            'form' => $form,
            'eventProfileFeilds'=>$eventProfileFeildValue->getEventFeild(),
            'event'=>$eventProfileFeildValue->getEventFeild()->getEvent()
            
        ]);
    }

    /**
     * @Route("/{id}", name="event_profile_feild_value_delete", methods={"POST"})
     */
    public function delete(Request $request, EventProfileFeildValue $eventProfileFeildValue): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eventProfileFeildValue->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($eventProfileFeildValue);
            $entityManager->flush();
        }

        return $this->redirectToRoute('event_profile_feild_value_index', [], Response::HTTP_SEE_OTHER);
    }
}
