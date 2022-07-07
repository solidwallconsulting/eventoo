<?php

namespace App\Controller;

use App\Entity\EventStands;
use App\Entity\StandVideos;
use App\Form\StandVideosType;
use App\Repository\StandConfigurationsRepository;
use App\Repository\StandVideosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
/**
 * @Route("/common/stand-videos")
 */
class StandVideosController extends AbstractController
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
     * @Route("/stand/{id}", name="stand_videos_index", methods={"GET"})
     */
    public function index(StandVideosRepository $standVideosRepository, EventStands $stand,StandConfigurationsRepository $standConfigurationsRepository): Response
    {

        // check for stand 

       // check for stand 

       $profile = $stand->getParticipant()->getProfile();

       // check if theres a configuration for this profile ( can create a stand )
       $config = $standConfigurationsRepository->findOneBy(['profile'=>$profile]);

       $leftVideos = 0;

       if($config != null){
           $leftVideos = ( $config->getMaximumNumberOfVideos() - sizeof( $stand->getStandVideos()) );

           
       }
        
        return $this->render('stand_videos/index.html.twig', [
            'stand_videos' => $standVideosRepository->findBy(['stand'=>$stand]),
            'leftVideos'=>$leftVideos,
            'stand'=>$stand
        ]);
    }

    /**
     * @Route("/new/stand/{id}", name="stand_videos_new", methods={"GET","POST"})
     */
    public function new(TranslatorInterface $translator, SessionInterface $session, Request $request, EventStands $stand, StandConfigurationsRepository $standConfigurationsRepository): Response
    {

        // check for stand 

        $profile = $stand->getParticipant()->getProfile();

        // check if theres a configuration for this profile ( can create a stand )
        $config = $standConfigurationsRepository->findOneBy(['profile'=>$profile]);

        $leftVideos = 0;

        if($config != null){
            $leftVideos = ( $config->getMaximumNumberOfVideos() - sizeof( $stand->getStandVideos()) );

            
        }


        if ($leftVideos == 0) {

            $message = $translator->trans(
                'Vous avez atteint la limite de capacité de ce stand',
                array(),
                'messages',
                $this->detectLanguage($session)
            ); 
            return $this->redirectToRoute('stand_videos_index', ['id'=>$stand->getId(),'error'=>$message], Response::HTTP_SEE_OTHER);

        } else {
            
            $standVideo = new StandVideos();
            $standVideo->setStand($stand);

            $form = $this->createForm(StandVideosType::class, $standVideo,['lng'=>$this->detectLanguage($session)]);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($standVideo);
                $entityManager->flush();

                return $this->redirectToRoute('stand_videos_index', ['id'=>$standVideo->getStand()->getId()], Response::HTTP_SEE_OTHER);
            }

            return $this->renderForm('stand_videos/new.html.twig', [
                'stand_video' => $standVideo,
                'form' => $form,
            ]);

        }
        
    }


    

    /**
     * @Route("/{id}/edit", name="stand_videos_edit", methods={"GET","POST"})
     */
    public function edit(TranslatorInterface $translator, SessionInterface $session,Request $request, StandVideos $standVideo): Response
    {
        $form = $this->createForm(StandVideosType::class, $standVideo,['lng'=>$this->detectLanguage($session)]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('stand_videos_index', ['id'=>$standVideo->getStand()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('stand_videos/edit.html.twig', [
            'stand_video' => $standVideo,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="stand_videos_delete", methods={"POST"})
     */
    public function delete(Request $request, StandVideos $standVideo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$standVideo->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($standVideo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('stand_videos_index', ['id'=>$standVideo->getStand()->getId()], Response::HTTP_SEE_OTHER);
    }
}
