<?php

namespace App\Tests\Entity\Contact;

use App\Entity\Contact;
use PHPUnit\Framework\TestCase;

class EntityContactTest extends TestCase
{
    public function testFirstnameFormat()
    {
        $contact = new Contact();

        $contact->setFirstname('  John  ');
        $this->assertEquals('John', $contact->getFirstname());

        $contact->setFirstname('John    ');
        $this->assertEquals('John', $contact->getFirstname());

        $contact->setFirstname('     John');
        $this->assertEquals('John', $contact->getFirstname());

        $contact->setFirstname('john');
        $this->assertEquals('John', $contact->getFirstname());
        
    }

    public function testLastnameFormat()
    {
        $contact = new Contact();

        $contact->setLastname('  Doe  ');
        $this->assertEquals('Doe', $contact->getLastname());

        $contact->setLastname('Doe    ');
        $this->assertEquals('Doe', $contact->getLastname());

        $contact->setLastname('     Doe');
        $this->assertEquals('Doe', $contact->getLastname());

        $contact->setLastname('doe');
        $this->assertEquals('Doe', $contact->getLastname());
    }

    public function testEmailFormat()
    {
        $contact = new Contact();

        $contact->setEmail('     john@doe.com     ');
        $this->assertEquals('john@doe.com', $contact->getEmail());

        $contact->setEmail('john@doe.com     ');
        $this->assertEquals('john@doe.com', $contact->getEmail());

        $contact->setEmail('     john@doe.com');
        $this->assertEquals('john@doe.com', $contact->getEmail());

        $contact->setEmail('JOHN@DOE.COM     ');
        $this->assertEquals('john@doe.com', $contact->getEmail());

        $contact->setEmail('     JOHN@DOE.COM');
        $this->assertEquals('john@doe.com', $contact->getEmail());

        $contact->setEmail('JOHN@DOE.COM');
        $this->assertEquals('john@doe.com', $contact->getEmail());

    }

    public function testPhoneFormat() {

        $contact = new Contact();

        $contact->setPhone('0628519475');
        $this->assertEquals('+33 628519475', $contact->getPhone());

        $contact->setPhone('0628519475');
        $this->assertEquals('+33 628519475', $contact->getPhone());

        $contact->setPhone('0628519475');
        $this->assertEquals('+33 628519475', $contact->getPhone());

    }

    public function testSocialFormat()
    {
        $contact = new Contact();

        $contact->setSocial('https://www.facebook.com/johndoe     ');
        $this->assertEquals('https://www.facebook.com/johndoe', $contact->getSocial());

        $contact->setSocial('     https://www.facebook.com/johndoe');
        $this->assertEquals('https://www.facebook.com/johndoe', $contact->getSocial());

        $contact->setSocial('HTTPS://WWW.FACEBOOK.COM/JOHNDOE');
        $this->assertEquals('https://www.facebook.com/johndoe', $contact->getSocial());
    }

}