<?php

namespace App\Controller;

use App\Entity\Exposer;
use App\Form\ExposerType;
use App\Repository\ExposerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/common/exposer")
 */
class ExposerController extends AbstractController
{
    /**
     * @Route("/", name="exposer_index", methods={"GET"})
     */
    public function index(ExposerRepository $exposerRepository): Response
    {
        return $this->render('exposer/index.html.twig', [
            'exposers' => $exposerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="exposer_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $exposer = new Exposer();
        $form = $this->createForm(ExposerType::class, $exposer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($exposer);
            $entityManager->flush();

            return $this->redirectToRoute('exposer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('exposer/new.html.twig', [
            'exposer' => $exposer,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="exposer_show", methods={"GET"})
     */
    public function show(Exposer $exposer): Response
    {
        return $this->render('exposer/show.html.twig', [
            'exposer' => $exposer,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="exposer_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Exposer $exposer): Response
    {
        $form = $this->createForm(ExposerType::class, $exposer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
             /** @var UploadedFile $image */
             
             $image = $form->get('logoURL')->getData();
            
             if ($image) {
                 $newFilename = uniqid().'.'.$image->guessExtension();
 
                 // Move the file to the directory where brochures are stored
                 try { 
                     $image->move('assets/img/events/exposers/',
                         $newFilename
                     );
                     $exposer->setLogoURL('/assets/img/events/exposers/'.$newFilename);
                 } catch (FileException $e) { 
                      
                 } 
                 
             }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('events_details               ', ['id'=>$exposer->getEvent()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('exposer/edit.html.twig', [
            'exposer' => $exposer,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="exposer_delete", methods={"POST"})
     */
    public function delete(Request $request, Exposer $exposer): Response
    {
        if ($this->isCsrfTokenValid('delete'.$exposer->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($exposer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('exposer_index', [], Response::HTTP_SEE_OTHER);
    }
}
