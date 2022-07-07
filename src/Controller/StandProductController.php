<?php

namespace App\Controller;

use App\Entity\EventStands;
use App\Entity\StandProduct;
use App\Form\StandProductType;
use App\Repository\StandConfigurationsRepository;
use App\Repository\StandProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
/**
 * @Route("/common/stand-product")
 */
class StandProductController extends AbstractController
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
     * @Route("/stand/{id}", name="stand_product_index", methods={"GET"})
     */
    public function index(StandProductRepository $standProductRepository, EventStands $stand, StandConfigurationsRepository $standConfigurationsRepository ): Response
    {


        // check for stand 

        $profile = $stand->getParticipant()->getProfile();

        // check if theres a configuration for this profile ( can create a stand )
        $config = $standConfigurationsRepository->findOneBy(['profile'=>$profile]);

        $leftProduct = 0;

        if($config != null){
            $leftProduct = ( $config->getMaximumNumberOfProducts() - sizeof( $stand->getStandProducts()) );

            
        }

        

        return $this->render('stand_product/index.html.twig', [
            'stand_products' => $standProductRepository->findBy(['stand'=>$stand]),
            'stand'=>$stand,
            'leftProduct'=>$leftProduct
        ]);
    }

    /**
     * @Route("/new/stand/{id}", name="stand_product_new", methods={"GET","POST"})
     */
    public function new(SessionInterface $session, TranslatorInterface $translator, Request $request, EventStands $stand, StandConfigurationsRepository $standConfigurationsRepository): Response
    {

        // check for stand 

        $profile = $stand->getParticipant()->getProfile();

        // check if theres a configuration for this profile ( can create a stand )
        $config = $standConfigurationsRepository->findOneBy(['profile'=>$profile]);

        $leftProduct = 0;

        if($config != null){
            $leftProduct = ( $config->getMaximumNumberOfProducts() - sizeof( $stand->getStandProducts()) );

            
        }

        if ($leftProduct == 0) {
            $message = $translator->trans(
                'Vous avez atteint la limite de capacité de ce stand',
                array(),
                'messages',
                $this->detectLanguage($session)
            );


            return $this->redirectToRoute('stand_product_index', ['id'=>$stand->getId(),'error'=>$message], Response::HTTP_SEE_OTHER);
        } else {
            

        $standProduct = new StandProduct();
        $standProduct->setStand($stand);

        $form = $this->createForm(StandProductType::class, $standProduct,['lng'=>$this->detectLanguage($session)]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


             /** @var UploadedFile $image */
             
             $image = $form->get('photoURL')->getData();
            
             if ($image) {
                 $newFilename = uniqid().'.'.$image->guessExtension();
 
                 // Move the file to the directory where brochures are stored
                 try { 
                     $image->move('assets/img/events/stands/products/',
                         $newFilename
                     );
                     $standProduct->setPhotoURL('/assets/img/events/stands/products/'.$newFilename);
                 } catch (FileException $e) { 
                     
                 } 
                 
             }


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($standProduct);
            $entityManager->flush();

            return $this->redirectToRoute('stand_product_index', ['id'=>$stand->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('stand_product/new.html.twig', [
            'stand_product' => $standProduct,
            'form' => $form,
        ]);

        }
        

    }

    /**
     * @Route("/{id}", name="stand_product_show", methods={"GET"})
     */
    public function show(StandProduct $standProduct): Response
    {
        return $this->render('stand_product/show.html.twig', [
            'stand_product' => $standProduct,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="stand_product_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, StandProduct $standProduct,SessionInterface $session): Response
    {
        $form = $this->createForm(StandProductType::class, $standProduct,['lng'=>$this->detectLanguage($session)]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $image */
             
            $image = $form->get('photoURL')->getData();
            
            if ($image) {
                $newFilename = uniqid().'.'.$image->guessExtension();

                // Move the file to the directory where brochures are stored
                try { 
                    $image->move('assets/img/events/stands/products/',
                        $newFilename
                    );
                    $standProduct->setPhotoURL('/assets/img/events/stands/products/'.$newFilename);
                } catch (FileException $e) { 
                    
                } 
                
            }


            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('stand_product_index', ['id'=>$standProduct->getStand()->getId()], Response::HTTP_SEE_OTHER);

        }

        return $this->renderForm('stand_product/edit.html.twig', [
            'stand_product' => $standProduct,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="stand_product_delete", methods={"POST"})
     */
    public function delete(Request $request, StandProduct $standProduct): Response
    {
        if ($this->isCsrfTokenValid('delete'.$standProduct->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($standProduct);
            $entityManager->flush();
        }

        return $this->redirectToRoute('stand_product_index', ['id'=>$standProduct->getStand()->getId()], Response::HTTP_SEE_OTHER);
    }
}
