<?php

namespace App\Controller;

use Cocur\Slugify\SlugifyInterface;
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
    public function index(Request $request, string $title): Response
    {
        $expectedSlug = 'follow-job-homepage';

        if ($this->slugify->slugify($title) !== $expectedSlug) {
            return new RedirectResponse($this->generateUrl('home', ['title' => $expectedSlug]));
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'slug' => $expectedSlug
        ]);
    }
}