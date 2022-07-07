<?php

namespace App\Controller;

use App\Entity\EventProfiles;
use App\Entity\Events;
use App\Entity\StandConfigurations;
use App\Form\StandConfigurationsType;
use App\Repository\ProfileRepository;
use App\Repository\StandConfigurationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/web-master/stand/configurations")
 */
class StandConfigurationsController extends AbstractController
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
     * @Route("/list/{id}", name="stand_configurations_index", methods={"GET"})
     */
    public function index(StandConfigurationsRepository $standConfigurationsRepository, Events $event): Response
    {
        return $this->render('stand_configurations/index.html.twig', [
            'event'=>$event,
            'stand_configurations' => $standConfigurationsRepository->findBy(['event'=> $event ]),
        ]);
    }

    /**
     * @Route("/new/event/{id}", name="stand_configurations_new", methods={"GET","POST"})
     */
    public function new(Request $request,Events $event,SessionInterface $session, ProfileRepository $profileRepository,  TranslatorInterface $translator): Response
    {
        $profiles = $profileRepository->findBy(['event'=>$event]);

        $standConfiguration = new StandConfigurations();
        $standConfiguration->setEvent($event);

        $form = $this->createForm(StandConfigurationsType::class, $standConfiguration,['profiles'=>$profiles, 'lng'=>$this->detectLanguage($session)]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           try {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($standConfiguration);
            $entityManager->flush();

            return $this->redirectToRoute('stand_configurations_index', ['id'=>$event->getId()], Response::HTTP_SEE_OTHER);

           } catch (\Throwable $th) {
            $message = $translator->trans(
                'Le profil choisi a déjà une configuration',
                array(),
                'messages',
                $this->detectLanguage($session)
            );

            return $this->redirectToRoute('stand_configurations_new', ['id'=>$event->getId(),'error'=>$message], Response::HTTP_SEE_OTHER);
           }
        }

        return $this->renderForm('stand_configurations/new.html.twig', [
            'stand_configuration' => $standConfiguration,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="stand_configurations_show", methods={"GET"})
     */
    public function show(StandConfigurations $standConfiguration): Response
    {
        return $this->render('stand_configurations/show.html.twig', [
            'stand_configuration' => $standConfiguration,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="stand_configurations_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, StandConfigurations $standConfiguration,SessionInterface $session,ProfileRepository $profileRepository): Response
    {

        $profiles = $profileRepository->findBy(['event'=>$standConfiguration->getEvent()]);

        $form = $this->createForm(StandConfigurationsType::class, $standConfiguration,['profiles'=>$profiles ,'lng'=>$this->detectLanguage($session)]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('stand_configurations_index', ['id'=>$standConfiguration->getEvent()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('stand_configurations/edit.html.twig', [
            'stand_configuration' => $standConfiguration,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="stand_configurations_delete", methods={"POST"})
     */
    public function delete(Request $request, StandConfigurations $standConfiguration): Response
    {
        if ($this->isCsrfTokenValid('delete'.$standConfiguration->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($standConfiguration);
            $entityManager->flush();
        }

        return $this->redirectToRoute('stand_configurations_index', [], Response::HTTP_SEE_OTHER);
    }
}
