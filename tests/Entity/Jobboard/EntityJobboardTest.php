<?php

namespace App\Tests\Entity\Jobboard;

use App\Entity\JobBoard;
use PHPUnit\Framework\TestCase;

class EntityJobboardTest extends TestCase
{
    public function testNameFormat()
    {
        $jobboard = new JobBoard();

        $jobboard->setName('Job Board     ');
        $this->assertEquals('Job Board', $jobboard->getName());

        $jobboard->setName('     Job Board');
        $this->assertEquals('Job Board', $jobboard->getName());

        $jobboard->setName('job board');
        $this->assertEquals('Job Board', $jobboard->getName());

    }

    public function testLinkFormat()
    {
        $link = new JobBoard();

        $link->setLink('https://www.indeed.com     ');
        $this->assertEquals('https://www.indeed.com', $link->getLink());

        $link->setLink('     https://www.indeed.com');
        $this->assertEquals('https://www.indeed.com', $link->getLink());

        $link->setLink('HTTPS://WWW.INDEED.COM');
        $this->assertEquals('https://www.indeed.com', $link->getLink());
    }
}