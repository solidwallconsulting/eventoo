<?php

namespace App\Controller;

use App\Repository\ClientsRepository;
use App\Repository\EventsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;


class AppController extends AbstractController
{

    // change local translation 
    /**
     * @Route("/config/lng", name="switch_lng")
     */
    public function switchLanguage(Request $request,SessionInterface $session): Response
    {
 
        $locale = $session->get('lng');

        if ($locale == null ) {
            $session->set('lng','fr');
        }else{
            if ($locale == 'en_EN') {
                $session->set('lng','fr'); 
            }else if($locale == 'fr'){
                $session->set('lng','en_EN');
            }
        }



        if ($this->getUser() != null) {
            if ($this->getUser()->getRoles()[0] == 'ROLE_ADMIN' ) {
            return $this->redirectToRoute('web_master_route');

            
            }else if( $this->getUser()->getRoles()[0] == 'ROLE_CLIENT' ){
                return $this->redirectToRoute('eventoo_dashboard_route');
            }
            else if( $this->getUser()->getRoles()[0] == 'ROLE_PARTICIPANT' ){
                return $this->redirectToRoute('app_dashboard_route');
            }

        }else{
            
            return $this->redirectToRoute('app_login');
        }
 

        
    }


    /**
     * @Route("/config/choice/{lng}", name="switch_lng_choice")
     */
    public function switchLanguageChoice(Request $request,SessionInterface $session,$lng): Response
    {
  

        $session->set('lng',$lng); 

        if ($this->getUser()->getRoles()[0] == 'ROLE_ADMIN' ) {
            return $this->redirectToRoute('web_master_route');

            
        }else if( $this->getUser()->getRoles()[0] == 'ROLE_CLIENT' ){
            return $this->redirectToRoute('eventoo_dashboard_route');
        }

        else if( $this->getUser()->getRoles()[0] == 'ROLE_PARTICIPANT' ){
            return $this->redirectToRoute('app_dashboard_route');
        }

        
    }



    

    /**
     * @Route("/", name="index_route")
     */
    public function index(): Response
    {
        

        return $this->redirectToRoute('app_login');

        
    }




    /**
     * @Route("/web-master", name="web_master_route")
     */
    public function web_master_index_route( ClientsRepository $clientsRepository,EventsRepository $eventsRepository ): Response
    {
        //return $this->redirectToRoute('clients_index');
        // will be changed in the future
        return $this->render('app/web-master.html.twig', [ 
            'events'=>$clientsRepository->findAll(),
            "clients"=>$eventsRepository->findAll()
        ]);
    }

    /**
     * @Route("/web-master/configuration", name="configuration_index")
     */
    public function configuration_index(): Response
    {
         
         
        return $this->render('app/config.html.twig', [ ]);
    }


    



    // client part
    
    /**
     * @Route("/eventoo-dashboard", name="eventoo_dashboard_route")
     */
    public function eventooDashboard(): Response
    {
        return $this->render('app/client.html.twig', [ 
        ]);
    }
 
}
