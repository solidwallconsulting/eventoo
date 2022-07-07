<?php

namespace App\Controller;

use App\Entity\Notes;
use App\Form\ClientUpdateType;
use App\Form\NotesType;
use App\Models\ClientModel;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/eventoo-dashboard")
 */

class ProfileController extends AbstractController
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
     * @Route("/my-profile", name="profile_route")
     */
    public function index( Request $request,SessionInterface $session,  TranslatorInterface $translator): Response
    {
        $client = $this->getUser()->getClients();


        /*** note section ***/
        $note = new Notes();
        $form = $this->createForm(NotesType::class, $note,['lng'=>$this->detectLanguage($session)]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $note->setClient($client);
            $note->setDate(new DateTime());
            $note->setIsAdminNote(false);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($note);
            $entityManager->flush();

            // empty the note
            $message = $translator->trans(
                'Ajouté avec succès',
                array(),
                'messages',
                $this->detectLanguage($session)
            );
           // TranslatorInterface $translator
            // ,SessionInterface $session
            // ,'ok'=>$message 

            return $this->redirectToRoute('profile_route', [ 'ok'=>$message], Response::HTTP_SEE_OTHER);
        }


        $clientUpdateModel = new ClientModel();

       


        $clientUpdateModel->setFirstname($client->getUser()->getFirstname());
        $clientUpdateModel->setLastname($client->getUser()->getLastname());
        $clientUpdateModel->setPhone($client->getCountryIndex().' '.$client->getUser()->getPhone());
        $clientUpdateModel->setClientName($client->getClientName());
        $clientUpdateModel->setCivility($client->getCivility());
        $clientUpdateModel->setFunction($client->getFunctionnality() ); 
        $clientUpdateModel->setCountryIndex($client->getCountryIndex());

           
        $clientForm = $this->createForm(ClientUpdateType::class, $clientUpdateModel,['lng'=>$this->detectLanguage($session)]);
        $clientForm->handleRequest($request);

        if ($clientForm->isSubmitted() && $clientForm->isValid()) {
            
            $client->setClientName($clientUpdateModel->getClientName());
            $client->setCivility($clientUpdateModel->getCivility());
            $client->setFunctionnality($clientUpdateModel->getFunction());

            

            $client->setCountryIndex($clientUpdateModel->getCountryIndex());


            $this->getDoctrine()->getManager()->flush();
             

            $user= $client->getUser();

            $user->setFirstname($clientUpdateModel->getFirstname());
            $user->setLastname($clientUpdateModel->getLastname());
            $user->setPhone($clientUpdateModel->getPhone());




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

            return $this->redirectToRoute('profile_route', [ 'ok'=>$message], Response::HTTP_SEE_OTHER);
            
        }
           
        /*** end note section ***/


        $parameters = $request->request;
        $files = $request->files;
        $method = $request->getMethod();

 



        // photo update


        if ($method == 'POST') { 
            if ($parameters->get('photo-user-update') != null) {
                $user= $client->getUser();

                
                $image = $files->get('photo-client'); 


                // save the user
                if ($image) {
                    $newFilename = uniqid().'.'.$image->guessExtension();
    
                    // Move the file to the directory where brochures are stored
                    try { 
    
                        
                        $image->move('assets/img/clients',
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }
     
                    $user->setPhotoURL('/assets/img/clients/'.$newFilename);
                    $this->getDoctrine()->getManager()->flush();

                } 
    
            }
            
        }



        if ($method == 'POST') { 
            if ($parameters->get('logo-user-update') != null) {
                $user= $client->getUser();

                
                $image = $files->get('logo-client'); 


                // save the user
                if ($image) {
                    $newFilename = uniqid().'.'.$image->guessExtension();
    
                    // Move the file to the directory where brochures are stored
                    try { 
    
                        
                        $image->move('assets/img/clients/logos',
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }
     
                    $user->getClients()->setLogoURL('/assets/img/clients/logos/'.$newFilename);
                    $this->getDoctrine()->getManager()->flush();

                } 
    
            }
            
        }


         
        return $this->render('profile/index.html.twig', [ 

            'client' => $client,
            'note' => $note,
            'noteForm' => $form->createView(),
            'clientUpdateModel' => $clientUpdateModel,
            'clientForm' => $clientForm->createView(),
            

        ]);
    }
}
