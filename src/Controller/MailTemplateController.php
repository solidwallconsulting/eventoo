<?php

namespace App\Controller;

use App\Entity\Events;
use App\Entity\MailTemplate;
use App\Form\MailTemplateType;
use App\Repository\MailTemplateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/common/mailing-template")
 */
class MailTemplateController extends AbstractController
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
     * @Route("/event/{id}", name="mail_template_index", methods={"GET"})
     */
    public function index(MailTemplateRepository $mailTemplateRepository, Events $event): Response
    {

        $list = $mailTemplateRepository->findBy(['event'=>$event->getId()]);
 

        return $this->render('mail_template/index.html.twig', [
            'mail_templates' =>$list ,
            'event'=>$event
        ]);
    }

    /**
     * @Route("/event/new/{id}", name="mail_template_new", methods={"GET","POST"})
     */
    public function new(Request $request, Events $event, SessionInterface $session): Response
    {
        $mailTemplate = new MailTemplate();
        $form = $this->createForm(MailTemplateType::class, $mailTemplate,['lng'=>$this->detectLanguage($session)]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $mailTemplate->setEvent($event);

             
             
               $entityManager = $this->getDoctrine()->getManager();
               $entityManager->persist($mailTemplate);
               $entityManager->flush();
              

            


              return $this->redirectToRoute('mail_template_index', ['id'=>$event->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('mail_template/new.html.twig', [
            'mail_template' => $mailTemplate,
            'form' => $form,
            'event'=>$event
        ]);
    }

    /**
     * @Route("/{id}", name="mail_template_show", methods={"GET"})
     */
    public function show(MailTemplate $mailTemplate): Response
    {
        return $this->render('mail_template/show.html.twig', [
            'mail_template' => $mailTemplate,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="mail_template_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, MailTemplate $mailTemplate, SessionInterface $session): Response
    {
        
        $profiles = $mailTemplate->getProfiles();
        
        $profilesArray = [];
        

        foreach ($profiles as $key => $value) {
            array_push($profilesArray, $value->getId() );
        }

        //dump($profilesArray);


        $mailTemplate->setProfiles([]);

        $form = $this->createForm(MailTemplateType::class, $mailTemplate,['lng'=>$this->detectLanguage($session)]);
        $form->handleRequest($request);

        

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mail_template_index', ['id'=>$mailTemplate->getEvent()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('mail_template/edit.html.twig', [
            'mail_template' => $mailTemplate,
            'form' => $form,
            'event'=>$mailTemplate->getEvent(),
            'profiles'=>$profilesArray
        ]);
    }

    /**
     * @Route("/{id}", name="mail_template_delete", methods={"POST"})
     */
    public function delete(Request $request, MailTemplate $mailTemplate): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mailTemplate->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($mailTemplate);
            $entityManager->flush();
        }

        return $this->redirectToRoute('mail_template_index', ["id"=>$mailTemplate->getEvent()->getId()], Response::HTTP_SEE_OTHER);
    }
}
