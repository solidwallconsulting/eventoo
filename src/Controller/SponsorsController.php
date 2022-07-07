<?php

namespace App\Controller;

use App\Entity\Sponsors;
use App\Form\SponsorsType;
use App\Repository\SponsorsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/common/sponsors")
 */
class SponsorsController extends AbstractController
{
    /**
     * @Route("/", name="sponsors_index", methods={"GET"})
     */
    public function index(SponsorsRepository $sponsorsRepository): Response
    {
        return $this->render('sponsors/index.html.twig', [
            'sponsors' => $sponsorsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="sponsors_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $sponsor = new Sponsors();
        $form = $this->createForm(SponsorsType::class, $sponsor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sponsor);
            $entityManager->flush();

            return $this->redirectToRoute('sponsors_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sponsors/new.html.twig', [
            'sponsor' => $sponsor,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="sponsors_show", methods={"GET"})
     */
    public function show(Sponsors $sponsor): Response
    {
        return $this->render('sponsors/show.html.twig', [
            'sponsor' => $sponsor,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sponsors_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Sponsors $sponsor): Response
    {
        $form = $this->createForm(SponsorsType::class, $sponsor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

             /** @var UploadedFile $image */
             
             $image = $form->get('logoURL')->getData();
            
             if ($image) {
                 $newFilename = uniqid().'.'.$image->guessExtension();
 
                 // Move the file to the directory where brochures are stored
                 try { 
                     $image->move('assets/img/events/sponsors/',
                         $newFilename
                     );
                     $sponsor->setLogoURL('/assets/img/events/sponsors/'.$newFilename);
                 } catch (FileException $e) { 
                     
                 } 
                 
             }


            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('events_details', ['id'=>$sponsor->getEvent()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sponsors/edit.html.twig', [
            'sponsor' => $sponsor,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="sponsors_delete", methods={"POST"})
     */
    public function delete(Request $request, Sponsors $sponsor): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sponsor->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sponsor);
            $entityManager->flush();
        }

        return $this->redirectToRoute('events_details', ["id"=>$sponsor->getEvent()->getId()], Response::HTTP_SEE_OTHER);
    }
}
