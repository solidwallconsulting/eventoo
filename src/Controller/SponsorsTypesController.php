<?php

namespace App\Controller;

use App\Entity\SponsorsTypes;
use App\Form\SponsorsTypesType;
use App\Repository\SponsorsTypesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/web-master/sponsors-types")
 */
class SponsorsTypesController extends AbstractController
{
    /**
     * @Route("/", name="sponsors_types_index", methods={"GET"})
     */
    public function index(SponsorsTypesRepository $sponsorsTypesRepository): Response
    {
        return $this->render('sponsors_types/index.html.twig', [
            'sponsors_types' => $sponsorsTypesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="sponsors_types_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $sponsorsType = new SponsorsTypes();
        $form = $this->createForm(SponsorsTypesType::class, $sponsorsType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sponsorsType);
            $entityManager->flush();

            return $this->redirectToRoute('sponsors_types_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sponsors_types/new.html.twig', [
            'sponsors_type' => $sponsorsType,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="sponsors_types_show", methods={"GET"})
     */
    public function show(SponsorsTypes $sponsorsType): Response
    {
        return $this->render('sponsors_types/show.html.twig', [
            'sponsors_type' => $sponsorsType,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sponsors_types_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SponsorsTypes $sponsorsType): Response
    {
        $form = $this->createForm(SponsorsTypesType::class, $sponsorsType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sponsors_types_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sponsors_types/edit.html.twig', [
            'sponsors_type' => $sponsorsType,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="sponsors_types_delete", methods={"POST"})
     */
    public function delete(Request $request, SponsorsTypes $sponsorsType): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sponsorsType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sponsorsType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sponsors_types_index', [], Response::HTTP_SEE_OTHER);
    }
}
