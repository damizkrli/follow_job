<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testHomepageRedirectoCorrectSlug()
    {
        // Crée un client HTTP pour simuler des requêtes.
        $client = static::createClient();

        // Envoie une requête GET à l'URL
        $crawler = $client->request('GET', '/home');

        // Vérifie que la réponse est une redirection
        $this->assertTrue($client->getResponse()->isRedirect());

        // Suit la redirection
        $client->followRedirect();

        // Vérifie que la réponse après la redirection est réussie (code 200).
        $this->assertResponseIsSuccessful('Redirection OK : 200');

        // Vérifie que le contenu de la page contient un élément h1 avec le texte HomeController.
        $this->assertSelectorTextContains('h1', "HomeController");

    }

    public function testHomePageWithCorrectSlug()
    {
        // Créer un client pour simuler des requêtes HTTP
        $client = static::createClient();

        // Envoie une requête GET
        $crawler = $client->request('GET', 'follow_job_homepage');

        // Vérifie que la réponse est un code 200
        $this->assertResponseIsSuccessful();

        // Vérifie que la réponse contient un titre H1 et un test HomeController
        $this->assertSelectorTextContains('h1', "HomeController");
    }

}