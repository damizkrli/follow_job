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
    #[Route('/external/link', name: 'app_external_link')]
    public function index(): Response
    {
        return $this->render('external_link/index.html.twig', [
            'controller_name' => 'ExternalLinkController',
        ]);
    }

    #[Route('/external-link/new', name: 'external_link_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $link = new ExternalLink();
        $form = $this->createForm(ExternalLinkType::class, $link);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($link);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('external_link/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/external-links/manage', name: 'external_link_manage')]
    public function manage(ExternalLinkRepository $repo): Response
    {
        return $this->render('external_link/manage.html.twig', [
            'links' => $repo->findAll(),
        ]);
    }

    #[Route('/external-link/update/{id}', name: 'external_link_update', methods: ['POST'])]
    public function update(int $id, Request $request, EntityManagerInterface $em, ExternalLinkRepository $repo): Response
    {
        $link = $repo->find($id);

        if (!$link) {
            throw $this->createNotFoundException('Lien introuvable');
        }

        $link->setName($request->request->get('name'));
        $link->setUrl($request->request->get('url'));

        $em->flush();

        $this->addFlash('success', 'Lien mis à jour.');
        return $this->redirectToRoute('external_link_manage');
    }
}
