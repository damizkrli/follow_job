<?php

namespace App\Controller;

use App\Entity\ExternalLink;
use App\Form\ExternalLinkType;
use App\Repository\ExternalLinkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ExternalLinkController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ExternalLinkRepository $externalLinkRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->externalLinkRepository = $externalLinkRepository;
    }

    #[Route('/liens-externes', name: 'app_external_link')]
    public function index(): Response
    {
        return $this->render('external_link/index.html.twig', [
            'controller_name' => 'ExternalLinkController',
        ]);
    }

    #[Route('/liens-externes/ajouter', name: 'external_link_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $link = new ExternalLink();
        $form = $this->createForm(ExternalLinkType::class, $link);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($link);
            $this->entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('external_link/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/liens-externes/modification', name: 'external_link_manage')]
    public function manage(): Response
    {
        return $this->render('external_link/manage.html.twig', [
            'links' => $this->externalLinkRepository->findAll(),
        ]);
    }

    #[Route('/external-link/update/{id}', name: 'external_link_update', methods: ['POST'])]
    public function update(int $id, Request $request): Response
    {
        $link = $this->externalLinkRepository->find($id);

        if (!$link) {
            throw $this->createNotFoundException('Lien introuvable');
        }

        $link->setName($request->request->get('name'));
        $link->setUrl($request->request->get('url'));

        $this->entityManager->flush();

        $this->addFlash('success', 'Lien mis à jour.');
        return $this->redirectToRoute('external_link_manage');
    }

    #[Route('/external-links/delete/{id}', name: 'external_link_delete', methods: ['POST'])]
    public function delete(Request $request, ExternalLink $link): Response
    {
        if ($this->isCsrfTokenValid('delete' . $link->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($link);
            $this->entityManager->flush();
            $this->addFlash('success', 'Lien supprimé.');
        }

        return $this->redirectToRoute('external_link_manage');
    }

}
