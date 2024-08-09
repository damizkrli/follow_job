<?php

namespace App\Tests\unit\Entity\Application;

use App\Entity\Application;
use PHPUnit\Framework\TestCase;

class EntityApplicationTest extends TestCase
{
    public function testJobTitleFormat()
    {
        $application = new Application();

        $application->setJobTitle('développeur web fullstack');
        $this->assertEquals('Développeur Web Fullstack', $application->getJobTitle());

        $application->setJobTitle('Développeur Web Fullstack     ');
        $this->assertEquals('Développeur Web Fullstack', $application->getJobTitle());

        $application->setJobTitle('     Développeur Web Fullstack     ');
        $this->assertEquals('Développeur Web Fullstack', $application->getJobTitle());

        $application->setJobTitle('     Développeur Web Fullstack');
        $this->assertEquals('Développeur Web Fullstack', $application->getJobTitle());
    }

    public function testLinkFormat()
    {
        $application = new Application();

        $application->setLink('https://www.google.fr     ');
        $this->assertEquals('https://www.google.fr', $application->getLink());

        $application->setLink('     https://www.google.fr');
        $this->assertEquals('https://www.google.fr', $application->getLink());

        $application->setLink('     https://www.google.fr     ');
        $this->assertEquals('https://www.google.fr', $application->getLink());

        $application->setLink('HTTPS://WWW.GOOGLE.FR');
        $this->assertEquals('https://www.google.fr', $application->getLink());
    }

    public function testNoteFormat()
    {
        $application = new Application();

        $application->setNote("des informations sur l'entreprise");
        $this->assertEquals("Des informations sur l'entreprise", $application->getNote());

        $application->setNote("des informations sur l'entreprise     ");
        $this->assertEquals("Des informations sur l'entreprise", $application->getNote());

        $application->setNote("     des informations sur l'entreprise");
        $this->assertEquals("Des informations sur l'entreprise", $application->getNote());

        $application->setNote("     des informations sur l'entreprise     ");
        $this->assertEquals("Des informations sur l'entreprise", $application->getNote());

        $application->setNote("DES INFORMATIONS SUR L'ENTREPRISE");
        $this->assertEquals("Des informations sur l'entreprise", $application->getNote());
    }

    public function testStatutFormat()
    {
        $application = new Application();

        $application->setStatut('Envoyee');
        $this->assertEquals('ENVOYEE', $application->getStatut());

        $application->setStatut('Envoyee     ');
        $this->assertEquals('ENVOYEE', $application->getStatut());

        $application->setStatut('     Envoyee');
        $this->assertEquals('ENVOYEE', $application->getStatut());

        $application->setStatut('    Envoyee     ');
        $this->assertEquals('ENVOYEE', $application->getStatut());

    }

}
