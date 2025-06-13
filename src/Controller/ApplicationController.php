<?php

namespace App\Controller;

use App\Entity\Application;
use App\Entity\Status;
use App\Form\ApplicationSearchType;
use App\Form\ApplicationType;
use App\Repository\ApplicationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
#[Route('/candidatures')]
class ApplicationController extends AbstractController
{

    public function __construct(
        private ApplicationRepository $applicationRepository, 
        private EntityManagerInterface $entityManager, 
        private PaginatorInterface $paginator,
        private ApplicationSearchType $applicationSearchType,
    )
    {
        $this->entityManager = $entityManager;
        $this->applicationRepository = $applicationRepository;
        $this->paginator = $paginator;
        $this->applicationSearchType = $applicationSearchType;
    }

    #[Route('/', name: 'app_application_index', methods: ['GET', 'POST'])]
    public function index(Request $request): Response|JsonResponse
    {
        $statuses = $this->entityManager->getRepository(Status::class)->findAll();

        if ($request->isXmlHttpRequest()) {
            $field = $request->query->get('field');
            $term = $request->query->get('term', '');

            if (strlen($term) < 2) {
                return new JsonResponse([]);
            }

            $allowedFields = ['company', 'jobTitle', 'jobboard'];

            if (!in_array($field, $allowedFields, true)) {
                return new JsonResponse(['error' => 'Invalid field'], Response::HTTP_BAD_REQUEST);
            }

            $results = match ($field) {
                'company' => $this->applicationRepository->findCompanySuggestions($term),
                'jobTitle' => $this->applicationRepository->findJobTitleSuggestions($term),
                'jobboard' => $this->applicationRepository->findJobBoardSuggestions($term),
            };

            return new JsonResponse($results);
        }

        $searchForm = $this->createForm(ApplicationSearchType::class, null, [
            'method' => 'GET',
        ]);
        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $query = $this->applicationRepository->findApplicationsWithSearch($searchForm->getData());
        } else {
            $query = $this->applicationRepository->findApplicationsWithSearch([]);
        }

        $pagination = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );

        $refusedStatus = $this->entityManager->getRepository(Status::class)->findOneBy(['name' => 'Refusee']);
        $refusedApplications = [];

        if ($refusedStatus) {
            $refusedApplications = $this->applicationRepository->findBy(['status' => $refusedStatus]);
        }

        $application = new Application();
        $form = $this->createForm(ApplicationType::class, $application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (null === $application->getStatus()) {
                $defaultStatus = $this->entityManager
                    ->getRepository(Status::class)
                    ->findOneBy(['name' => 'Envoyee']);

                if ($defaultStatus) {
                    $application->setStatus($defaultStatus);
                }
            }
            $this->entityManager->persist($application);
            $this->entityManager->flush();

            $this->addFlash('success', 'Candidature ajoutée avec succès.');

            return $this->redirectToRoute('app_application_index');
        }

        return $this->render('application/indexes/index.html.twig', [
            'pagination' => $pagination,
            'form' => $form->createView(),
            'searchForm' => $searchForm->createView(),
            'refusedApplications' => $refusedApplications,
            'statuses' => $statuses,
        ]);
    }

    #[Route('/{id}/modifier/', name: 'app_application_edit', methods: ['POST'])]
    public function edit(Request $request, Application $application): Response
    {
        $data = $request->request->all('application');

        if (empty($data)) {
            $this->addFlash('error', 'Données invalides.');
            return $this->redirectToRoute('app_application_index');
        }

        $application->setJobTitle($data['job_title'] ?? $application->getJobTitle());
        $application->setCity($data['city'] ?? $application->getCity());
        $application->setLink($data['link'] ?? $application->getLink());
        $application->setCompany($data['company'] ?? $application->getCompany());
        $application->setJobboard($data['jobboard'] ?? $application->getJobboard());
        $application->setNote($data['note'] ?? $application->getNote());
        $application->setSent(!empty($data['sent']) ? new \DateTime($data['sent']) : null);
        $application->setResponse(!empty($data['response']) ? new \DateTime($data['response']) : null);

        if (!empty($data['status'])) {
            $status = $this->entityManager->getRepository(Status::class)->find($data['status']);
            if ($status) {
                $application->setStatus($status);
            } else {
                $this->addFlash('error', 'Statut invalide.');
                return $this->redirectToRoute('app_application_index');
            }
        }

        $this->entityManager->flush();

        $this->addFlash('success', 'Candidature modifiée avec succès.');

        $redirectUrl = $request->request->get('redirect_to');
        if ($redirectUrl) {
            return new RedirectResponse($redirectUrl);
        }

        return $this->redirectToRoute('app_application_index');
    }

    #[Route('/{id}', name: 'app_application_delete', methods: ['POST'])]
    public function delete(Request $request, Application $application): Response
    {
        if ($this->isCsrfTokenValid('delete'.$application->getId(), $request->getPayload()->getString('_token'))) {
            $this->entityManager->remove($application);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('app_application_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/details/{id}', name: 'app_application_show', methods: ['GET'])]
    public function show(Application $application): Response
    {
        return $this->render('application/show.html.twig', [
            'application' => $application,
        ]);
    }

    #[Route('candidatures-refusees', name: 'app_application_refused', methods: ['GET'])]
    public function applicationRefused(): Response {
        $refusedApplication = $this->applicationRepository->findBy(['statut' => 'Refusée']);

        return $this->render('application/refused.html.twig', [
            'applications' => $refusedApplication,
        ]);
    }
}
