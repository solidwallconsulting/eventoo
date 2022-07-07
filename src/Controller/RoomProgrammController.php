<?php

namespace App\Controller;

use App\Entity\EventRooms;
use App\Entity\RoomProgramm;
use App\Form\RoomProgrammType;
use App\Repository\ExposerRepository;
use App\Repository\ParticipantRepository;
use App\Repository\ProfileRepository;
use App\Repository\RoomProgrammRepository;
use App\Repository\SponsorsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/common/room-programm")
 */
class RoomProgrammController extends AbstractController
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
     * @Route("/room/{id}", name="room_programm_index", methods={"GET"})
     */
    public function index(ParticipantRepository $participantRepository, ExposerRepository $exposerRepository, RoomProgrammRepository $roomProgrammRepository, EventRooms $room, SponsorsRepository $sponsorsRepository): Response
    {
        $list = $roomProgrammRepository->findBy(['room'=>$room]);

        

        $finalList = [];

        foreach ($list as $key => $value) {
            $tmpSponsors = [];

            // fetch sponsors
            foreach ($value->getSponsors() as $sk => $sv) {
               $s = $sponsorsRepository->findOneBy(['id'=>$sv]);
               array_push($tmpSponsors,$s);
            }

            $value->setSponsors($tmpSponsors);



            $tmpExposers = [];

            // fetch exposer
            foreach ($value->getExposers() as $ke => $ve) {
               $e = $exposerRepository->findOneBy(['id'=>$ve]);
               array_push($tmpExposers,$e);
            }

            $value->setExposers($tmpExposers);


            // participants

            $tmpParticipants = [];

            // fetch exposer
            foreach ($value->getParticipants() as $kp => $vp) {
               $p = $participantRepository->findOneBy(['id'=>$vp]);
               array_push($tmpParticipants,$p);
            }

            $value->setParticipants($tmpParticipants);

        }


         
        dump($list);
        return $this->render('room_programm/index.html.twig', [
            'room_programms' => $list,
            'room'=>$room
        ]);
    }

    /**
     * @Route("/room/new-program/{id}", name="room_programm_new", methods={"GET","POST"})
     */
    public function new(Request $request, EventRooms $room, ProfileRepository $profileRepository,SessionInterface $session ): Response
    {
        $roomProgramm = new RoomProgramm();
        $roomProgramm->settype(0);

        $roomProgramm->setRoom($room);

        // first  we get the list of available participants
        

        $workersProfilesIDs = $roomProgramm->getRoom()->getWorkerProfiles();

        

        $availableParticipants = [];

        foreach ($workersProfilesIDs as $key => $profileID) {
          
            $profile = $profileRepository->findOneBy(['id'=>$profileID]);

            $participants = $profile->getParticipants();

            foreach ($participants as $key => $p) {
                $availableParticipants[$p->getUser()->getFirstName().' '.$p->getUser()->getLastName().' * '.$p->getProfile()->getLabel()] = $p->getId();
            }
        }
 
        // list if sponsors
        $sponsors = [];
        $exhibitors = [];

        foreach ($room->getEvent()->getSponsors() as $key => $value) {
            $sponsors[$value->getName()]=$value->getId();
        }

        foreach ($room->getEvent()->getExposers() as $key => $value) {
            $exhibitors[$value->getName()]=$value->getId();
        }

        $form = $this->createForm(RoomProgrammType::class, $roomProgramm,['exhibitors'=>$exhibitors, 'sponsors'=>$sponsors, 'participants'=>$availableParticipants,'lng'=>$this->detectLanguage($session)]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {



            

             /** @var UploadedFile $image */
             
             $image = $form->get('mainSponsorPhotoURL')->getData();
            
             if ($image) {
                 $newFilename = uniqid().'.'.$image->guessExtension();
 
                 // Move the file to the directory where brochures are stored
                 try { 
                     $image->move('assets/img/events/programs/',
                         $newFilename
                     );
                     $roomProgramm->setMainSponsorPhotoURL('/assets/img/events/programs/'.$newFilename);
                 } catch (FileException $e) { 
                    $roomProgramm->setMainSponsorPhotoURL('/assets/img/events/programs/null.png');
                 } 
                 
             }

 

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($roomProgramm);
            $entityManager->flush();

            return $this->redirectToRoute('room_programm_index', ['id'=>$roomProgramm->getRoom()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('room_programm/new.html.twig', [
            'room' => $roomProgramm,
            'form' => $form,
        ]);
    }

 

    /**
     * @Route("/{id}/edit", name="room_programm_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, RoomProgramm $roomProgramm ,    ProfileRepository $profileRepository,SessionInterface $session ): Response
    { 
        $room = $roomProgramm->getRoom();
        
        $workersProfilesIDs = $roomProgramm->getRoom()->getWorkerProfiles();

        

        $availableParticipants = [];

        foreach ($workersProfilesIDs as $key => $profileID) {
          
            $profile = $profileRepository->findOneBy(['id'=>$profileID]);

            $participants = $profile->getParticipants();

            foreach ($participants as $key => $p) {
                $availableParticipants[$p->getUser()->getFirstName().' '.$p->getUser()->getLastName().' * '.$p->getProfile()->getLabel()] = $p->getId();
            }
        }
 
        // list if sponsors
        $sponsors = [];
        $exhibitors = [];

        foreach ($room->getEvent()->getSponsors() as $key => $value) {
            $sponsors[$value->getName()]=$value->getId();
        }

        foreach ($room->getEvent()->getExposers() as $key => $value) {
            $exhibitors[$value->getName()]=$value->getId();
        }


        $tmp = [];
        foreach ($roomProgramm->getTags() as $key => $value) {
            $tmp[$value]=$value;
        }

        $form = $this->createForm(RoomProgrammType::class, $roomProgramm,['tags'=>$tmp, 'exhibitors'=>$exhibitors, 'sponsors'=>$sponsors, 'participants'=>$availableParticipants,'lng'=>$this->detectLanguage($session)]);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

             /** @var UploadedFile $image */
             
             $image = $form->get('mainSponsorPhotoURL')->getData();
            
             if ($image) {
                 $newFilename = uniqid().'.'.$image->guessExtension();
 
                 // Move the file to the directory where brochures are stored
                 try { 
                     $image->move('assets/img/events/programs/',
                         $newFilename
                     );
                     $roomProgramm->setMainSponsorPhotoURL('/assets/img/events/programs/'.$newFilename);
                 } catch (FileException $e) { 
                   
                 } 
                 
             }



            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('room_programm_index', ['id'=>$roomProgramm->getRoom()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('room_programm/edit.html.twig', [
            'room' => $roomProgramm,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="room_programm_delete", methods={"POST"})
     */
    public function delete(Request $request, RoomProgramm $roomProgramm): Response
    {
        if ($this->isCsrfTokenValid('delete'.$roomProgramm->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($roomProgramm);
            $entityManager->flush();
        }

        return $this->redirectToRoute('room_programm_index', ['id'=>$roomProgramm->getRoom()->getId()], Response::HTTP_SEE_OTHER);
    }
}
