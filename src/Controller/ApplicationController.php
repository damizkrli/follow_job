<?php

namespace App\Controller;

use App\Entity\Application;
use App\Form\ApplicationType;
use App\Repository\ApplicationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/candidatures')]
class ApplicationController extends AbstractController
{
    #[Route('/', name: 'app_application_index', methods: ['GET', 'POST'])]
    public function index(Request $request, ApplicationRepository $applicationRepository, EntityManagerInterface $em, PaginatorInterface $paginator): Response
    {
        $query = $applicationRepository->createQueryBuilder('a')->orderBy('a.sent', 'DESC')->getQuery();
        $pagination = $paginator->paginate($query, $request->query->getInt('page', 1), 10);
        $refusedApplications = $applicationRepository->findBy(['statut' => 'Refusée']);
    
        $application = new Application();
        $form = $this->createForm(ApplicationType::class, $application);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($application);
            $em->flush();
        
            $this->addFlash('success', 'Candidature ajoutée avec succès.');
        
            return $this->redirectToRoute('app_application_index');
        }
    
        return $this->render('application/indexes/index.html.twig', [
            'pagination' => $pagination,
            'form' => $form->createView(),
            'refusedApplications' => $refusedApplications,
        ]);
    }

    #[Route('/{id}/modifier/', name: 'app_application_edit', methods: ['POST'])]
    public function edit(Request $request, Application $application, EntityManagerInterface $entityManager): Response
    {
        $data = $request->request->all('application'); // <-- ici maintenant c'est bon
    
        if (empty($data)) {
            $this->addFlash('error', 'Données invalides.');
            return $this->redirectToRoute('app_application_index');
        }
    
        // Mets à jour les champs
        $application->setJobTitle($data['job_title'] ?? $application->getJobTitle());
        $application->setStatut($data['statut'] ?? $application->getStatut());
        $application->setSent(!empty($data['sent']) ? new \DateTime($data['sent']) : null);
        $application->setResponse(!empty($data['response']) ? new \DateTime($data['response']) : null);
        $application->setLink($data['link'] ?? $application->getLink());
        $application->setCompany($data['company'] ?? $application->getCompany());
        $application->setJobboard($data['jobboard'] ?? $application->getJobboard());
        $application->setNote($data['note'] ?? $application->getNote());
    
        $entityManager->flush();
    
        $this->addFlash('success', 'Candidature modifiée avec succès.');
        return $this->redirectToRoute('app_application_index');
    }


    #[Route('/{id}', name: 'app_application_delete', methods: ['POST'])]
    public function delete(Request $request, Application $application, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$application->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($application);
            $entityManager->flush();
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
    public function applicationRefused(ApplicationRepository $applicationRepository): Response {
        $refusedApplication = $applicationRepository->findBy(['statut' => 'Refusée']);

        return $this->render('application/refused.html.twig', [
            'applications' => $refusedApplication,
        ]);
    }
}
