<?php

namespace App\Controller;

use App\Entity\NotesCategories;
use App\Form\NotesCategoriesType;
use App\Repository\NotesCategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/web-master/notes-categories")
 */
class NotesCategoriesController extends AbstractController
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
     * @Route("/", name="notes_categories_index", methods={"GET"})
     */
    public function index(NotesCategoriesRepository $notesCategoriesRepository): Response
    {
        return $this->render('notes_categories/index.html.twig', [
            'notes_categories' => $notesCategoriesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="notes_categories_new", methods={"GET","POST"})
     */
    public function new(Request $request, SessionInterface $session, TranslatorInterface $translator): Response
    {
        $notesCategory = new NotesCategories();
        $form = $this->createForm(NotesCategoriesType::class, $notesCategory,['lng'=>$this->detectLanguage($session)]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($notesCategory);
            $entityManager->flush();


            $message = $translator->trans(
                'Donnée mise a jour avec succès',
                array(),
                'messages',
                $this->detectLanguage($session)
            );
            // TranslatorInterface $translator
            // ,SessionInterface $session
            // ,'ok'=>$message


            return $this->redirectToRoute('notes_categories_index', ['ok'=>$message], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('notes_categories/new.html.twig', [
            'notes_category' => $notesCategory,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="notes_categories_show", methods={"GET"})
     */
    public function show(NotesCategories $notesCategory): Response
    {
        return $this->render('notes_categories/show.html.twig', [
            'notes_category' => $notesCategory,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="notes_categories_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, NotesCategories $notesCategory, SessionInterface $session, TranslatorInterface $translator): Response
    {
        $form = $this->createForm(NotesCategoriesType::class, $notesCategory,['lng'=>$this->detectLanguage($session)]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();


            $message = $translator->trans(
                'Donnée mise a jour avec succès',
                array(),
                'messages',
                $this->detectLanguage($session)
            );
            // TranslatorInterface $translator
            // ,SessionInterface $session
            // ,'ok'=>$message

            return $this->redirectToRoute('notes_categories_index', ['ok'=>$message], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('notes_categories/edit.html.twig', [
            'notes_category' => $notesCategory,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="notes_categories_delete", methods={"POST"})
     */
    public function delete(Request $request, NotesCategories $notesCategory): Response
    {
        if ($this->isCsrfTokenValid('delete'.$notesCategory->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($notesCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('notes_categories_index', [], Response::HTTP_SEE_OTHER);
    }
}
