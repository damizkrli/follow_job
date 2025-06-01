<?php

namespace App\Controller;

use App\Entity\ExternalLink;
use App\Form\ExternalLinkType;
use App\Repository\ExternalLinkRepository;
use App\Service\JobOfferApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    #[Route('/', name: 'app_application_home')]
    public function index(
        Request $request,
        JobOfferApiService $jobService,
        EntityManagerInterface $em,
        ExternalLinkRepository $externalLinkRepository
    ): Response {

        $externalLinks = $externalLinkRepository->findAll();

        $externalLink = new ExternalLink();
        $form = $this->createForm(ExternalLinkType::class, $externalLink);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($externalLink);
            $em->flush();
            $this->addFlash('success', 'Lien ajouté avec succès.');
            return $this->redirectToRoute('home', []);
        }

        $offers = $jobService->fetchOffers();

        return $this->render('home/index.html.twig', [
            'offers' => $offers,
            'external_links' => $externalLinks,
            'form' => $form->createView(),
        ]);
    }
}
