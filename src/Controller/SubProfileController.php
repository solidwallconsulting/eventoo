<?php

namespace App\Controller;

use App\Entity\EventProfiles;
use App\Entity\SubProfile;
use App\Form\SubProfileType;
use App\Repository\SubProfileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/common/sub-profiles")
 */
class SubProfileController extends AbstractController
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
     * @Route("/profile/{id}", name="sub_profile_index", methods={"GET"})
     */
    public function index(SubProfileRepository $subProfileRepository,EventProfiles $profile): Response
    {
        return $this->render('sub_profile/index.html.twig', [
            'sub_profiles' => $subProfileRepository->findBy(['profile'=>$profile]),
            'event'=>$profile->getEvent(),
            'profile'=>$profile
        ]);
    }

    /**
     * @Route("/profile/{id}/new", name="sub_profile_new", methods={"GET","POST"})
     */
    public function new(SessionInterface $session, Request $request,EventProfiles $profile): Response
    {
        $subProfile = new SubProfile();
        $subProfile->setProfile($profile);


        $form = $this->createForm(SubProfileType::class, $subProfile,['lng'=>$this->detectLanguage($session)]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($subProfile);
            $entityManager->flush();

            return $this->redirectToRoute('sub_profile_index', ['id'=>$profile->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sub_profile/new.html.twig', [
            'sub_profile' => $subProfile,
            'form' => $form,
            'profile'=>$profile,
            'event'=>$profile->getEvent()
        ]);
    }

    /**
     * @Route("/{id}", name="sub_profile_show", methods={"GET"})
     */
    public function show(SubProfile $subProfile): Response
    {
        return $this->render('sub_profile/show.html.twig', [
            'sub_profile' => $subProfile,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sub_profile_edit", methods={"GET","POST"})
     */
    public function edit(SessionInterface $session, Request $request, SubProfile $subProfile): Response
    {
        $form = $this->createForm(SubProfileType::class, $subProfile,['lng'=>$this->detectLanguage($session)]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sub_profile_index', ['id'=>$subProfile->getProfile()->getId()], Response::HTTP_SEE_OTHER);
        }
        $profile = $subProfile->getProfile();

        return $this->renderForm('sub_profile/edit.html.twig', [
            'sub_profile' => $subProfile,
            'form' => $form,
            'profile'=>$profile,
            'event'=>$profile->getEvent()
        ]);
    }

    /**
     * @Route("/{id}", name="sub_profile_delete", methods={"POST"})
     */
    public function delete(Request $request, SubProfile $subProfile): Response
    {
        if ($this->isCsrfTokenValid('delete'.$subProfile->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($subProfile);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sub_profile_index', ['id'=>$subProfile->getProfile()->getId()], Response::HTTP_SEE_OTHER);
    }
}
