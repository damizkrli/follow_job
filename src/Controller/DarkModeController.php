<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class DarkModeController extends AbstractController
{
    #[Route('/toggle-dark-mode', name: 'toggle_dark_mode')]
    public function toggle(Request $request): RedirectResponse
    {
        $session = $request->getSession();
        $current = $session->get('dark_mode', false);
        $session->set('dark_mode', !$current);

        $referer = $request->headers->get('referer');
        return $this->redirect($referer ?? $this->generateUrl('home', ['title' => 'follow-job-homepage']));
    }
}
