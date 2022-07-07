<?php

namespace App\Controller;

use App\Entity\EventStands;
use App\Entity\StandCatalogue;
use App\Form\StandCatalogueType;
use App\Repository\StandCatalogueRepository;
use App\Repository\StandConfigurationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Storage\SessionStorageInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/common/stand-catalogue")
 */
class StandCatalogueController extends AbstractController
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
     * @Route("/stand/{id}", name="stand_catalogue_index", methods={"GET"})
     */
    public function index(StandCatalogueRepository $standCatalogueRepository , EventStands $stand, StandConfigurationsRepository $standConfigurationsRepository  ): Response
    {

         // check for stand 

         $profile = $stand->getParticipant()->getProfile();

         // check if theres a configuration for this profile ( can create a stand )
         $config = $standConfigurationsRepository->findOneBy(['profile'=>$profile]);
 
         $leftCatalogue = 0;
 
         if($config != null){
             $leftCatalogue = ( $config->getMaximumNumberOfCatalogues()- sizeof( $stand->getStandCatalogues()) );
 
             
         }
         
        return $this->render('stand_catalogue/index.html.twig', [
            'stand_catalogues' => $standCatalogueRepository->findBy(['stand'=>$stand]), 
            'stand'=>$stand,
            'leftCatalogue'=>$leftCatalogue
        ]);
    }

    /**
     * @Route("/new/stand/{id}", name="stand_catalogue_new", methods={"GET","POST"})
     */
    public function new(TranslatorInterface $translator,SessionInterface $session, Request $request,EventStands $stand, StandConfigurationsRepository $standConfigurationsRepository): Response
    {


        // check for stand 

        $profile = $stand->getParticipant()->getProfile();

        // check if theres a configuration for this profile ( can create a stand )
        $config = $standConfigurationsRepository->findOneBy(['profile'=>$profile]);

        $leftCatalogue = 0;

        if($config != null){
            $leftCatalogue = ( $config->getMaximumNumberOfCatalogues()- sizeof( $stand->getStandCatalogues()) );

            
        }

        if ($leftCatalogue == 0) {
            $message = $translator->trans(
                'Vous avez atteint la limite de capacité de ce stand',
                array(),
                'messages',
                $this->detectLanguage($session)
            );


            return $this->redirectToRoute('stand_catalogue_index', ['id'=>$stand->getId(),'error'=>$message], Response::HTTP_SEE_OTHER);
        } else {
            $standCatalogue = new StandCatalogue();
            $standCatalogue->setStand($stand);
    
            $form = $this->createForm(StandCatalogueType::class, $standCatalogue,['lng'=>$this->detectLanguage($session)]);
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {

                 /** @var UploadedFile $image */
             
             $image = $form->get('catalogePDFURL')->getData();
            
             if ($image) {
                 $newFilename = uniqid().'.'.$image->guessExtension();
 
                 // Move the file to the directory where brochures are stored
                 try { 
                     $image->move('assets/img/events/stands/catalogues/',
                         $newFilename
                     );
                     $standCatalogue->setCatalogePDFURL('/assets/img/events/stands/catalogues/'.$newFilename);
                 } catch (FileException $e) { 
                     
                 } 
                 
             }


                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($standCatalogue);
                $entityManager->flush();
    
                return $this->redirectToRoute('stand_catalogue_index', ['id'=>$stand->getId()], Response::HTTP_SEE_OTHER);
            }
    
            return $this->renderForm('stand_catalogue/new.html.twig', [
                'stand_catalogue' => $standCatalogue,
                'form' => $form,
            ]);
        }
        
       
    }

    /**
     * @Route("/{id}", name="stand_catalogue_show", methods={"GET"})
     */
    public function show(StandCatalogue $standCatalogue): Response
    {
        return $this->render('stand_catalogue/show.html.twig', [
            'stand_catalogue' => $standCatalogue,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="stand_catalogue_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, StandCatalogue $standCatalogue, SessionInterface $session): Response
    {
        $form = $this->createForm(StandCatalogueType::class, $standCatalogue,['lng'=>$this->detectLanguage($session)]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

               /** @var UploadedFile $image */
             
               $image = $form->get('catalogePDFURL')->getData();
            
               if ($image) {
                   $newFilename = uniqid().'.'.$image->guessExtension();
   
                   // Move the file to the directory where brochures are stored
                   try { 
                       $image->move('assets/img/events/stands/catalogues/',
                           $newFilename
                       );
                       $standCatalogue->setCatalogePDFURL('/assets/img/events/stands/catalogues/'.$newFilename);
                   } catch (FileException $e) { 
                       
                   } 
                   
               }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('stand_catalogue_index', ['id'=>$standCatalogue->getStand()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('stand_catalogue/edit.html.twig', [
            'stand_catalogue' => $standCatalogue,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="stand_catalogue_delete", methods={"POST"})
     */
    public function delete(Request $request, StandCatalogue $standCatalogue): Response
    {
        if ($this->isCsrfTokenValid('delete'.$standCatalogue->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($standCatalogue);
            $entityManager->flush();
        }

        return $this->redirectToRoute('stand_catalogue_index', ['id'=>$standCatalogue->getStand()->getId()], Response::HTTP_SEE_OTHER);
    }
}
