<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\ParticipantFeildsImages;
use App\Entity\User;
use App\Repository\CountriesRepository;
use App\Repository\EventProfileFeildValueRepository;
use App\Repository\EventsRepository;
use App\Repository\ProfileRepository;
use App\Repository\SubProfileRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Contracts\Translation\TranslatorInterface;


class SecurityController extends AbstractController
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
     * @Route("/auth/{eventID}", name="app_login")
     */
    public function login($eventID = null,EventsRepository $eventsRepository , ProfileRepository $profileRepository ,AuthenticationUtils $authenticationUtils,Request $request,SessionInterface $session ): Response
    {
        if ($this->getUser()) {  
            // check roles 
            if ($this->getUser()->getRoles()[0] == 'ROLE_ADMIN' ) {
                return $this->redirectToRoute('web_master_route'); 
                
            }else if( $this->getUser()->getRoles()[0] == 'ROLE_CLIENT' ){
                return $this->redirectToRoute('eventoo_dashboard_route');

            } else if( $this->getUser()->getRoles()[0] == 'ROLE_PARTICIPANT' ){
                return $this->redirectToRoute('app_dashboard_route');
            } 

        } 
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

         
        if ($eventID == null) {
            return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
        }else{
            //$profile = $profileRepository->findOneBy(['uniqueID'=>$uniqueID]);
            $event = $eventsRepository->findOneBy(['unqueID'=>$eventID]);

            return $this->render('security/event-login-html.twig', [
                'last_username' => $lastUsername, 
                'error' => $error,
                'event'=>$event
                //'profile'=>$profile,
                //'uniqueID'=>$uniqueID
            ]);
        }
       
    }


 


    

    /**
     * @Route("/event-create-account/{uniqueID}", name="event_create_account")
     */
    public function event_login(CountriesRepository $countriesRepository, TranslatorInterface $translator, UserRepository $userRepository, SubProfileRepository $subProfileRepository, EventProfileFeildValueRepository $eventProfileFeildValueRepository, $uniqueID, ProfileRepository $profileRepository, Request $request,SessionInterface $session , UserPasswordEncoderInterface $passwordEncoder ): Response
    {
         
        $profile = $profileRepository->findOneBy(['uniqueID'=>$uniqueID]);
        $subprofiles = $profile->getSubProfiles();
        
        $method = $request->getMethod();


        $success='';
        $error='';

        if ($method == 'POST') {
                $parameters = $request->request; 


                // check if email already in use
                $email = trim($parameters->get('email'));

                if ($userRepository->findOneBy(['email'=>$email]) != null ) {
                    $error = $translator->trans(
                        'Cette adresse e-mail est déjà utilisée par un autre compte.',
                        array(),
                        'messages',
                        $this->detectLanguage($session)
                    );


                }else{
                    $user = new User();
 

                    $user->setFirstname(trim($parameters->get('name')));
                    $user->setLastname(trim($parameters->get('lastname')));
                    $user->setEmail(trim($parameters->get('email')));
                    $user->setPhone(trim($parameters->get('phone')));
                    $user->setSexe($parameters->get('civility'));



                    $user->setFunctionOccupation(trim($parameters->get('FonctionOccupation')));
                    $user->setCompanyEtablishment(trim($parameters->get('companyEtablisment'))); 


                    $user->setActivitySector(trim($parameters->get('activity_sector')));
                    $user->setYourOffre(trim($parameters->get('my_offer')));
                    $user->setYourNeeds(trim($parameters->get('my_needs')));

                    

                    
                    $country = null; 
                    $country = $countriesRepository->findOneBy(['id'=>$parameters->get('country')]); 

                    $user->setCountry($country);
                    $user->setCity(trim($parameters->get('city')));
                    


                    $password = $passwordEncoder->encodePassword($user, $parameters->get('password'));
                    
                    $user->setPassword($password); 
    
                    $user->setRoles(['ROLE_PARTICIPANT']);
                    $user->setPhotoURL("/assets/img/participants/default.png");
                    
    
    
                    $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($user);
                        $entityManager->flush();
    
    
                    $participant = new Participant();
    
                    $participant->setUser($user);
                    $participant->setProfile($profile);
    
    
                    if ($parameters->get('subprofile') != null) {
                        $subProfile = $subProfileRepository->findOneBy(['id'=>$parameters->get('subprofile')]);
                        $participant->setSubProfile($subProfile);
                    }
    
    
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($participant);
                    $entityManager->flush();
                    
                    // now we hundle the keys and values and we create new feilds for the new participants
                    // contains the diffrents values !! 
    
    
                    //  { ["parameters":protected]=> array(9) { ["name"]=> string(0) "" ["lastname"]=> string(0) "" ["phone"]=> string(0) "" ["email"]=> string(16) "admin@evento.com" ["password"]=> string(6) "123456" ["13_input"]=> string(2) "12" ["16_input"]=> string(18) "ninja 68_ tuinsia" ["18_input"]=> string(10) "ninja corp" ["17_input"]=> string(1) "4" } }
    
    
                    // map the profile feild
    
                    foreach ($profile->getEventAssociatedProfileFeilds() as $key => $value) {
                        $field = $value->getField();
    
                        $image  = new ParticipantFeildsImages();
                        $image->setParticipant($participant);
                        
    
                        $image->setLabelEN($field->getLabelEN());
                        $image->setLabelFr($field->getLabelFr());
    
                        // if feild has many values !! we need to get the associated entity !! 
                        if (sizeof($field->getEventProfileFeildValues()) != 0) {
                            
                        // $id = $parameters->get($field->getId().'_input');
                        // $valueDB = $eventProfileFeildValueRepository->findOneBy(["id"=>$id]);
                            
                            $image->setValue($parameters->get($field->getId().'_input'));
    
                        }else{
                            $image->setValue($parameters->get($field->getId().'_input'));
                        }
    
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($image);
                        $entityManager->flush(); 
                    }



                    $success = $translator->trans(
                        'Compte créé avec succès, vous pouvez vous connecter maintenant.',
                        array(),
                        'messages',
                        $this->detectLanguage($session)
                    );
                }
             
                

                
             

        }
         
 
        $a = (int) sizeof($profile->getParticipants());
        $b = (int) $profile->getParticipantsNumber();

        
 

        return $this->render('security/event-create-account.html.twig', [
            'profile'=>$profile,
            "a"=>$a,
            "b"=>$b,
            'subprofiles'=>$subprofiles,
            'success'=>$success,
            'error'=>$error,
            'uniqueID'=>$uniqueID,
            'countries'=>$countriesRepository->findAll()
            
        ]);
    }






    /**
     * @Route("/create-admin-account", name="app_create_account")
     */
    public function createAdminAccount( UserPasswordEncoderInterface $passwordEncoder): Response{
         
            /*$user = new User(); 
        
 
            $entityManager = $this->getDoctrine()->getManager();

            
            $user->setRoles(['ROLE_ADMIN']);
            $user->setPhotoURL('/assets/img/clients/default.png'); 
            $user->setFirstname('Admin'); 
            $user->setLastname('Evento'); 
            $user->setEmail('admin@evento.com'); 
            $user->setPhone('22334455'); 
            
            
            
            
            $user->setPassword($passwordEncoder->encodePassword($user,"123456"));


            $entityManager->persist($user);
            $entityManager->flush();*/
  

        return $this->redirectToRoute('app_login');
    }






    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
         
    }
}
