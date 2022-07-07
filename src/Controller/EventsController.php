<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Entity\Events;
use App\Entity\Exposer;
use App\Entity\Sponsors;
use App\Form\EventsType;
use App\Form\ExposerType;
use App\Form\SponsorsType;
use App\Repository\BtBMeetingRoomRepository;
use App\Repository\EventsRepository;
use App\Repository\EventStandsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/common/events")
 */
class EventsController extends AbstractController
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
     * @Route("/", name="events_index", methods={"GET"})
     */
    public function index(EventsRepository $eventsRepository): Response
    {
        return $this->render('events/index.html.twig', [
            'events' => $eventsRepository->findAll(),
        ]);
    }

    
 

    /**
     * @Route("/client/new/{id}", name="events_new", methods={"GET","POST"})
     */
    public function new(Request $request,Clients $client,SessionInterface $session, TranslatorInterface $translator): Response
    {
        $event = new Events();
        $event->setClient($client);

        $form = $this->createForm(EventsType::class, $event,['lng'=>$this->detectLanguage($session)]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $event->setUnqueID( sha1(uniqid()) );
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            // redirect to client profile

            $message = $translator->trans(
                'Ajouté avec succès',
                array(),
                'messages',
                $this->detectLanguage($session)
            );
            // TranslatorInterface $translator
            // ,SessionInterface $session
            // ,'ok'=>$message


            
            if ($this->getUser()->getRoles()[0] == 'ROLE_ADMIN') {
                return $this->redirectToRoute('clients_show', ['id'=>$client->getId(),'ok'=>$message], Response::HTTP_SEE_OTHER);
            } else {
                return $this->redirectToRoute('profile_route', ['id'=>$client->getId(),'ok'=>$message], Response::HTTP_SEE_OTHER);
            }



            

           
        }

        return $this->renderForm('events/new.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }

    

    /**
     * @Route("/{id}", name="events_show", methods={"GET","POST"})
     */
    public function show(Events $event,Request $request, TranslatorInterface $translator,SessionInterface $session): Response
    {

        $form = $this->createForm(EventsType::class, $event,["secondStep"=>true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $eventImage = $form->get('photoURL')->getData();


            // save the user
            if ($eventImage) {
                $newFilename = uniqid().'.'.$eventImage->guessExtension();

                // Move the file to the directory where brochures are stored
                try { 

                    
                    $eventImage->move('assets/img/clients/logos',
                        $newFilename
                    );
                    $event->setPhotoURL('/assets/img/clients/logos/'.$newFilename);
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
 
               
            }



            $eventLOGO = $form->get('logoURL')->getData();


            // save the user
            if ($eventLOGO) {
                $newFilename = uniqid().'.'.$eventLOGO->guessExtension();

                // Move the file to the directory where brochures are stored
                try { 

                    
                    $eventLOGO->move('assets/img/events/logos',
                        $newFilename
                    );
                    $event->setLogoURL('/assets/img/events/logos/'.$newFilename);
                } catch (FileException $e) {
                     
                }
 
                
            }


            $message = $translator->trans(
                'Donnée mise a jour avec succès',
                array(),
                'messages',
                $this->detectLanguage($session)
            );
           // TranslatorInterface $translator
            // ,SessionInterface $session
            // ,'ok'=>$message


            $this->getDoctrine()->getManager()->flush(); 
            return $this->redirectToRoute('events_show', ["id"=>$event->getId(),'ok'=>$message], Response::HTTP_SEE_OTHER);
        }  

        return $this->render('events/show.html.twig', [ 
            'event' => $event,
            'form' => $form->createView() 
        ]);
    }

    /**
     * @Route("/details/{id}", name="events_details", methods={"GET","POST"})
     */
    public function eventDetails(  Events $event,Request $request,SessionInterface $session, TranslatorInterface $translator): Response
    {
 

        $form = $this->createForm(EventsType::class, $event,['lng'=>$this->detectLanguage($session)]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            // redirect to client profile

            $message = $translator->trans(
                'Donnée mise a jour avec succès',
                array(),
                'messages',
                $this->detectLanguage($session)
            );
           // TranslatorInterface $translator
            // ,SessionInterface $session
            // ,'ok'=>$message
            return $this->redirectToRoute('events_details', ["id"=>$event->getId(),'ok'=>$message], Response::HTTP_SEE_OTHER);
        }



        /** Sponsor form */

        $sponsor = new Sponsors();
        $sponsorForm = $this->createForm(SponsorsType::class, $sponsor, ['lng'=>$this->detectLanguage($session)]);
        $sponsorForm->handleRequest($request);

        if ($sponsorForm->isSubmitted() && $sponsorForm->isValid()) {
            $sponsor->setEvent($event);

             /** @var UploadedFile $image */
             
            $image = $sponsorForm->get('logoURL')->getData();
            
            if ($image) {
                $newFilename = uniqid().'.'.$image->guessExtension();

                // Move the file to the directory where brochures are stored
                try { 
                    $image->move('assets/img/events/sponsors/',
                        $newFilename
                    );
                    $sponsor->setLogoURL('/assets/img/events/sponsors/'.$newFilename);
                } catch (FileException $e) { 
                    $sponsor->setLogoURL('/assets/media/users/blank.png');
                } 
                
            }else{
                $sponsor->setLogoURL('/assets/media/users/blank.png');
            }


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sponsor);
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
            return $this->redirectToRoute('events_details', ["id"=>$event->getId(),'ok'=>$message], Response::HTTP_SEE_OTHER);
 
        }
 


        /** exposer form */
        $exposer = new Exposer();
        $exposerForm = $this->createForm(ExposerType::class, $exposer);
        $exposerForm->handleRequest($request);

        if ($exposerForm->isSubmitted() && $exposerForm->isValid()) {

            $exposer->setEvent($event);

            
             /** @var UploadedFile $image */
             
             $image = $exposerForm->get('logoURL')->getData();
            
             if ($image) {
                 $newFilename = uniqid().'.'.$image->guessExtension();
 
                 // Move the file to the directory where brochures are stored
                 try { 
                     $image->move('assets/img/events/exposers/',
                         $newFilename
                     );
                     $exposer->setLogoURL('/assets/img/events/exposers/'.$newFilename);
                 } catch (FileException $e) { 
                     $exposer->setLogoURL('/assets/media/users/blank.png');
                 } 
                 
             }else{
                 $exposer->setLogoURL('/assets/media/users/blank.png');
             }
 

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($exposer);
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
            return $this->redirectToRoute('events_details', ["id"=>$event->getId(),'ok'=>$message], Response::HTTP_SEE_OTHER);
 
 
        } 



             // get the participants list

             $participants = [];

        

             $profiles = $event->getEventProfiles();
     
     
             foreach ($profiles as $key => $profile) {
                  $tmp = $profile->getParticipants();
                 
                  foreach ($tmp as $key => $participant) {
                      array_push($participants,$participant);
                  }
     
             }

        return $this->renderForm('events/event-details.html.twig', [ 
            'event' => $event,
            'eventForm' => $form, 
            'sponsorForm' => $sponsorForm, 
            'exposerForm' => $exposerForm,
            'participants'=>$participants
        ]);
    }

 

    /**
     * @Route("/{id}", name="events_delete", methods={"POST"})
     */
    public function delete(Request $request, Events $event): Response
    {
        if ($this->isCsrfTokenValid('delete'.$event->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($event);
            $entityManager->flush();
        }

        return $this->redirectToRoute('events_index', [], Response::HTTP_SEE_OTHER);
    }
}
