<?php

namespace App\Controller;

use App\Entity\ExternalLink;
use App\Form\ExternalLinkType;
use App\Repository\ExternalLinkRepository;
use App\Service\JobOfferApiService;
use Cocur\Slugify\SlugifyInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private SlugifyInterface $slugify;

    public function __construct(SlugifyInterface $slugify)
    {
        $this->slugify = $slugify;
    }

    #[Route('/{title}', name: 'home')]
    public function index(
        Request $request,
        string $title,
        JobOfferApiService $jobService,
        ExternalLinkRepository $externalLinkRepository,
        EntityManagerInterface $em
    ): Response {
        $expectedSlug = 'follow-job-homepage';

        if ($this->slugify->slugify($title) !== $expectedSlug) {
            return new RedirectResponse($this->generateUrl('home', ['title' => $expectedSlug]));
        }

        $externalLinks = $externalLinkRepository->findAll();

        $externalLink = new ExternalLink();
        $form = $this->createForm(ExternalLinkType::class, $externalLink);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($externalLink);
            $em->flush();
            $this->addFlash('success', 'Lien ajouté avec succès.');
            return $this->redirectToRoute('home', ['title' => $expectedSlug]);
        }

        $offers = $jobService->fetchOffers();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'slug' => $expectedSlug,
            'offers' => $offers,
            'external_links' => $externalLinks,
            'form' => $form->createView(),
        ]);
    }
}
