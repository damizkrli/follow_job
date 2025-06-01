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
use App\Service\ApplicationStatisticsService;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class HomeController extends AbstractController
{

    public function __construct(
        private JobOfferApiService $jobService,
        private EntityManagerInterface $entityManager,
        private ExternalLinkRepository $externalLinkRepository,
        private ApplicationStatisticsService $applicationStatisticsService,
    )
    {
        $this->jobService = $jobService;
        $this->entityManager = $entityManager;
        $this->externalLinkRepository = $externalLinkRepository;
        $this->applicationStatisticsService = $applicationStatisticsService;
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/', name: 'app_application_home')]
    public function index(Request $request): Response {

        $externalLinks = $this->externalLinkRepository->findAll();
        $applicationSentToday = $this->applicationStatisticsService->countApplicationsToday();
        $applicationsThisWeek = $this->applicationStatisticsService->countThisWeek();
        $applicationsThisMonth = $this->applicationStatisticsService->countThisMonth();
        $applicationsThisYear = $this->applicationStatisticsService->countThisYear();

        $externalLink = new ExternalLink();
        $form = $this->createForm(ExternalLinkType::class, $externalLink);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($externalLink);
            $this->entityManager->flush();
            $this->addFlash('success', 'Lien ajouté avec succès.');
            return $this->redirectToRoute('home', []);
        }

        $offers = $this->jobService->fetchOffers();

        return $this->render('home/index.html.twig', [
            'offers' => $offers,
            'external_links' => $externalLinks,
            'form' => $form->createView(),
            'applicationSentToday' => $applicationSentToday,
            'applicationsThisWeek' => $applicationsThisWeek,
            'applicationsThisMonth' => $applicationsThisMonth,
            'applicationsThisYear' => $applicationsThisYear,
        ]);
    }
}
