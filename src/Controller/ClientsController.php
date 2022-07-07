<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Entity\Notes;
use App\Entity\User;
use App\Form\ClientsType;
use App\Form\ClientUpdateType;
use App\Form\NotesType;
use App\Models\ClientModel;
use App\Repository\ClientsRepository;
use App\Repository\UserRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/web-master/clients")
 */
class ClientsController extends AbstractController
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
     * @Route("/", name="clients_index", methods={"GET"})
     */
    public function index(ClientsRepository $clientsRepository, Request $request,SessionInterface $session,TranslatorInterface $translator): Response
    {
        
         
         

        return $this->render('clients/index.html.twig', [ 
            'clients' => $clientsRepository->findAll(),

        ]);
    }

    /**
     * @Route("/new", name="clients_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder, TranslatorInterface $translator,SessionInterface $session, UserRepository $userRepository ): Response
    {
        $client = new Clients();
        $user = new User();


        $parameters = $request->request;
        $files = $request->files;
        $method = $request->getMethod();
 
        if ($method == 'POST') {  
            $user->setFirstname(trim($parameters->get('firstname')));
            $user->setLastname(trim($parameters->get('lastname')));
            $user->setEmail(trim($parameters->get('email')));
            $user->setPhone(trim($parameters->get('phone')));
            $user->setRoles(['ROLE_CLIENT']);
            
            

            $password = $passwordEncoder->encodePassword($user, $parameters->get('password'));
            
            $user->setPassword($password); 
 
            $photoUser = $files->get('photo'); 


            // save the user
            if ($photoUser) {
                $newFilename = uniqid().'.'.$photoUser->guessExtension();

                // Move the file to the directory where brochures are stored
                try { 

                    
                    $photoUser->move('assets/img/clients',
                        $newFilename
                    );
                    $user->setPhotoURL('/assets/img/clients/'.$newFilename);
                } catch (FileException $e) {
                    $user->setPhotoURL("/assets/img/null.jpg");
                }
 
                $user->setPhotoURL('/assets/img/clients/'.$newFilename);
            }else{
                $user->setPhotoURL("/assets/img/null.jpg");
            }


             
           

 

            // check for duplicaated email in the database

            $check = $userRepository->findOneBy(['email'=>trim($parameters->get('email')) ]);

            if ($check == null) {

                /**
                 * $entityManager = $this->getDoctrine()->getManager();
                 * $entityManager->persist($user);
                 * $entityManager->flush();
                 */
    
                // hundle the client
    
                $client->setClientName(trim($parameters->get('clientName')));
                $client->setFunctionnality(trim($parameters->get('function')));
                $client->setCivility(trim($parameters->get('civility')));
                $client->setCountryIndex($parameters->get('countryIndex'));
                $client->setUser($user);
    
                $logoImage = $files->get('logo'); 
    
    
                // save the user
                if ($logoImage) {
                    $newFilename = uniqid().'.'.$logoImage->guessExtension();
    
                    // Move the file to the directory where brochures are stored
                    try { 
    
                        
                        $logoImage->move('assets/img/clients/logos',
                            $newFilename
                        );
                        $client->setLogoURL('/assets/img/clients/logos/'.$newFilename);
                    } catch (FileException $e) {
                        $client->setLogoURL("/assets/img/null.jpg");
                    }
                }else{
                    $client->setLogoURL("/assets/img/null.jpg");
                }




                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($client);
                $entityManager->flush();



                // send verification mail
                $sendVerificationEmail = $parameters->get('sendVerificationEmail');

                if ($sendVerificationEmail != null) {
                    // send verification email
                }

                $message = $translator->trans(
                    'Client créé avec succès',
                    array(),
                    'messages',
                    $this->detectLanguage($session)
                );
                
    
                return $this->redirectToRoute('clients_index', ['success'=>true,'ok'=>$message], Response::HTTP_SEE_OTHER);
            }else{
                $message = $translator->trans(
                    'Cet e-mail est déjà utilisé par un autre compte',
                    array(),
                    'messages',
                    $this->detectLanguage($session)
                );

                return $this->redirectToRoute('clients_index', ['success'=>false,'error'=>$message], Response::HTTP_SEE_OTHER);
            }

            
        
        } 
 
         
        return $this->renderForm('clients/new.html.twig', [
            'ok'=>'hello world','error'=>"wiouw !!"
        ]);
    }

    /**
     * @Route("/{id}", name="clients_show", methods={"GET","POST"})
     */
    public function show( UserPasswordEncoderInterface $passwordEncoder, Clients $client, Request $request,SessionInterface $session, TranslatorInterface $translator): Response
    {

        /*** note section ***/
        $note = new Notes();
        $form = $this->createForm(NotesType::class, $note,['lng'=>$this->detectLanguage($session)]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $note->setClient($client);
            $note->setDate(new DateTime());
            $note->setIsAdminNote(true);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($note);
            $entityManager->flush();

            // empty the note

            $message = $translator->trans(
                'Note ajouté avec succès',
                array(),
                'messages',
                $this->detectLanguage($session)
            );
            // TranslatorInterface $translator
            // ,'ok'=>$message
 
            
            return $this->redirectToRoute('clients_show', ['id' => $client->getId(),'ok'=>$message]);
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
            // ,'ok'=>$message
 
            return $this->redirectToRoute('clients_show', ['id' => $client->getId(),'ok'=>$message]);
        }
           
        /*** end note section ***/


        
        $parameters = $request->request;
        $files = $request->files;
        $method = $request->getMethod();

 



        // photo update
        

        if ($method == 'POST') { 
            if ($parameters->get('logo-user-update') != null) {
                 
                $image = $files->get('logo-client'); 


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
     
                    $client->setLogoURL('/assets/img/clients/'.$newFilename);
                    $this->getDoctrine()->getManager()->flush();

                } 
    
            }

            if ($parameters->get('photo-user-update') != null) {
                 
                $image = $files->get('photo-client'); 
                $user = $client->getUser();


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
            if ($parameters->get('newpassword') != null) {

                $targetUser = $client->getUser(); 

                $password = $passwordEncoder->encodePassword($targetUser, $parameters->get('new-password'));
            
                $targetUser->setPassword($password); 

                $this->getDoctrine()->getManager()->flush();
            $message = $translator->trans(
                'Mot de passe mis à jour avec succès',
                array(),
                'messages',
                $this->detectLanguage($session)
            );



                return $this->redirectToRoute('clients_show', ['id' => $client->getId(),'ok'=>$message]);

            }
        }
        
        // end photo update

        return $this->render('clients/show.html.twig', [
            'client' => $client,
            'note' => $note,
            'noteForm' => $form->createView(),
            'clientUpdateModel' => $clientUpdateModel,
            'clientForm' => $clientForm->createView(),
            
        ]);
    }

    /**
     * @Route("/{id}/edit", name="clients_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Clients $client): Response
    {
        $form = $this->createForm(ClientsType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('clients_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('clients/edit.html.twig', [
            'client' => $client,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="clients_delete", methods={"POST"})
     */
    public function delete(Request $request, Clients $client): Response
    {
        if ($this->isCsrfTokenValid('delete'.$client->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($client);
            $entityManager->flush();
        }

        return $this->redirectToRoute('clients_index', [], Response::HTTP_SEE_OTHER);
    }
}
