<?php

namespace App\Controller;

use App\Entity\JobBoard;
use App\Form\JobBoardType;
use App\Repository\JobBoardRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/job/board')]
class JobBoardController extends AbstractController
{
    #[Route('/', name: 'app_job_board_index', methods: ['GET'])]
    public function index(JobBoardRepository $jobBoardRepository): Response
    {
        return $this->render('job_board/index.html.twig', [
            'job_boards' => $jobBoardRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_job_board_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $jobBoard = new JobBoard();
        $form = $this->createForm(JobBoardType::class, $jobBoard);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($jobBoard);
            $entityManager->flush();

            return $this->redirectToRoute('app_job_board_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('job_board/new.html.twig', [
            'job_board' => $jobBoard,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_job_board_show', methods: ['GET'])]
    public function show(JobBoard $jobBoard): Response
    {
        return $this->render('job_board/show.html.twig', [
            'job_board' => $jobBoard,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_job_board_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, JobBoard $jobBoard, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(JobBoardType::class, $jobBoard);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_job_board_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('job_board/edit.html.twig', [
            'job_board' => $jobBoard,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_job_board_delete', methods: ['POST'])]
    public function delete(Request $request, JobBoard $jobBoard, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$jobBoard->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($jobBoard);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_job_board_index', [], Response::HTTP_SEE_OTHER);
    }
}
