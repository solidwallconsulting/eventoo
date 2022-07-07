<?php

namespace App\Controller;

use App\Entity\EventProfileFeilds;
use App\Entity\Events;
use App\Form\EventProfileFeildsType;
use App\Repository\EventProfileFeildsRepository;
use SessionIdInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/common/event-profile-feilds")
 */
class EventProfileFeildsController extends AbstractController
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
     * @Route("/event/{id}", name="event_profile_feilds_index", methods={"GET","POST"})
     */
    public function index(Request $request, EventProfileFeildsRepository $eventProfileFeildsRepository, Events $event): Response
    {
        $method = $request->getMethod();
        $files = $request->files;

        if ($method == 'POST') {
            //dump($files);

            $introTheEventPhotoURL = $files->get('photo'); 


            // save the user
            if ($introTheEventPhotoURL) {
                $newFilename = uniqid().'.'.$introTheEventPhotoURL->guessExtension();

                // Move the file to the directory where brochures are stored
                try { 

                    
                    $introTheEventPhotoURL->move('assets/img/events/auth',
                        $newFilename
                    );
                    $event->setIntoTheEventPhotoURL('/assets/img/events/auth/'.$newFilename);
                    $this->getDoctrine()->getManager()->flush();
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
 
                
            }
        }



        return $this->render('event_profile_feilds/index.html.twig', [
            'event_profile_feilds' => $eventProfileFeildsRepository->findBy(['event'=>$event->getId()]),
            'event'=>$event
        ]);
    }

    /**
     * @Route("/new/event/{id}", name="event_profile_feilds_new", methods={"GET","POST"})
     */
    public function new(Request $request, Events $event, EventProfileFeildsRepository $eventProfileFeildsRepository): Response
    {
        $eventProfileFeild = new EventProfileFeilds();
        $form = $this->createForm(EventProfileFeildsType::class, $eventProfileFeild);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $eventProfileFeild->setEvent($event);
            $eventProfileFeild->setLingneOrder( sizeof($eventProfileFeildsRepository->findBy(['event'=>$event->getId()])) +1  );


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($eventProfileFeild);
            $entityManager->flush();

            return $this->redirectToRoute('event_profile_feilds_index', ['id'=>$event->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('event_profile_feilds/new.html.twig', [
            'event_profile_feild' => $eventProfileFeild,
            'form' => $form,
            'event'=>$event
        ]);
    }

    /**
     * @Route("/{id}", name="event_profile_feilds_show", methods={"GET"})
     */
    public function show(EventProfileFeilds $eventProfileFeild): Response
    {
        return $this->render('event_profile_feilds/show.html.twig', [
            'event_profile_feild' => $eventProfileFeild,
            'event'=>$eventProfileFeild->getEvent()->getId()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="event_profile_feilds_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EventProfileFeilds $eventProfileFeild): Response
    {
        $form = $this->createForm(EventProfileFeildsType::class, $eventProfileFeild,['isEditing'=>true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event_profile_feilds_index', ['id'=>$eventProfileFeild->getEvent()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('event_profile_feilds/edit.html.twig', [
            'event_profile_feild' => $eventProfileFeild,
            'form' => $form,
            'event'=>$eventProfileFeild->getEvent()
        ]);
    }

    /**
     * @Route("/{id}", name="event_profile_feilds_delete", methods={"POST"})
     */
    public function delete(Request $request, EventProfileFeilds $eventProfileFeild, SessionInterface $session): Response
    {
        $msg = '';

        try {
            if ($this->isCsrfTokenValid('delete'.$eventProfileFeild->getId(), $request->request->get('_token'))) {
            

                // first delete childs !!
    
                $childs = $eventProfileFeild->getEventProfileFeildValues();
    
                $assosiations = $eventProfileFeild->getEventAssociatedProfileFeilds();
    
                foreach ($childs as $key => $value) {
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->remove($value);
                    $entityManager->flush();
                }
    
                foreach ($assosiations as $key => $asso) {
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->remove($asso);
                    $entityManager->flush();
                }
    
                 
                
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($eventProfileFeild);
                $entityManager->flush();
            }

            $lng=$this->detectLanguage($session);
            $msg= $lng == "fr" ? "Champs supprimé avec succés" : 'Feild deleted successfully.';


            return $this->redirectToRoute('event_profile_feilds_index', ['id'=>$eventProfileFeild->getEvent()->getId(), 'ok'=>$msg], Response::HTTP_SEE_OTHER);
        } catch (\Throwable $th) {
            $lng=$this->detectLanguage($session);
            $msg= $lng == "fr" ? "Erreur lors de la suppression du champs" : 'Something went wrong while trying to delete the feild.';
            
            return $this->redirectToRoute('event_profile_feilds_index', ['id'=>$eventProfileFeild->getEvent()->getId(), 'error'=>$msg], Response::HTTP_SEE_OTHER);
        }



        
    }




}
