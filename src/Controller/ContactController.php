<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
#[Route('/contact')]
class ContactController extends AbstractController
{

    public function __construct(
        private ContactRepository $contactRepository, 
        private EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
        $this->contactRepository = $contactRepository;
    }

    #[Route('/', name: 'app_contact_index', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $contacts = $this->contactRepository->findAll();
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($contact);
            $this->entityManager->flush();

            $this->addFlash('success', 'Contact ajouté avec succès.');
            return $this->redirectToRoute('app_contact_index');
        }

        return $this->render('contact/index.html.twig', [
            'contacts' => $contacts,
            'form' => $form->createView(),
        ]);
    }


    #[Route('/new', name: 'app_contact_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($contact);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('contact/new.html.twig', [
            'contact' => $contact,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contact_show', methods: ['GET'])]
    public function show(Contact $contact): Response
    {
        return $this->render('contact/show.html.twig', [
            'contact' => $contact,
        ]);
    }

    #[Route('/contact/{id}/edit', name: 'app_contact_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Contact $contact): Response
    {
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', 'Contact modifié avec succès');
            return $this->redirectToRoute('app_contact_index');
        }
    
        return $this->redirectToRoute('app_contact_index');
    }


    #[Route('/{id}', name: 'app_contact_delete', methods: ['POST'])]
    public function delete(Request $request, Contact $contact): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contact->getId(), $request->getPayload()->getString('_token'))) {
            $this->entityManager->remove($contact);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
    }
}
