<?php

namespace App\Controller;

use App\Entity\RoomAccessProfiles;
use App\Form\RoomAccessProfilesType;
use App\Repository\RoomAccessProfilesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/room/access/profiles")
 */
class RoomAccessProfilesController extends AbstractController
{
    /**
     * @Route("/", name="room_access_profiles_index", methods={"GET"})
     */
    public function index(RoomAccessProfilesRepository $roomAccessProfilesRepository): Response
    {
        return $this->render('room_access_profiles/index.html.twig', [
            'room_access_profiles' => $roomAccessProfilesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="room_access_profiles_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $roomAccessProfile = new RoomAccessProfiles();
        $form = $this->createForm(RoomAccessProfilesType::class, $roomAccessProfile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($roomAccessProfile);
            $entityManager->flush();

            return $this->redirectToRoute('room_access_profiles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('room_access_profiles/new.html.twig', [
            'room_access_profile' => $roomAccessProfile,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="room_access_profiles_show", methods={"GET"})
     */
    public function show(RoomAccessProfiles $roomAccessProfile): Response
    {
        return $this->render('room_access_profiles/show.html.twig', [
            'room_access_profile' => $roomAccessProfile,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="room_access_profiles_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, RoomAccessProfiles $roomAccessProfile): Response
    {
        $form = $this->createForm(RoomAccessProfilesType::class, $roomAccessProfile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('room_access_profiles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('room_access_profiles/edit.html.twig', [
            'room_access_profile' => $roomAccessProfile,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="room_access_profiles_delete", methods={"POST"})
     */
    public function delete(Request $request, RoomAccessProfiles $roomAccessProfile): Response
    {
        if ($this->isCsrfTokenValid('delete'.$roomAccessProfile->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($roomAccessProfile);
            $entityManager->flush();
        }

        return $this->redirectToRoute('room_access_profiles_index', [], Response::HTTP_SEE_OTHER);
    }
}
