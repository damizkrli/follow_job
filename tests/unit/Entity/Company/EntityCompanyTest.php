<?php

namespace App\Tests\unit\Entity\Company;

use App\Entity\Company;
use PHPUnit\Framework\TestCase;

class EntityCompanyTest extends TestCase
{
    public function testNameFormat(): void
    {
        $company = new Company();

        $company->setName('France Travail');
        $this->assertEquals('France Travail', $company->getName());

        $company->setName('     France Travail     ');
        $this->assertEquals('France Travail', $company->getName());

        $company->setName('     France Travail');
        $this->assertEquals('France Travail', $company->getName());

        $company->setName('france travail');
        $this->assertEquals('France Travail', $company->getName());
    }

    public function testActivityFormat(): void
    {
        $company = new Company();

        $company->setActivity('Conseil en systèmes et logiciels informatiques     ');
        $this->assertEquals('Conseil En Systèmes Et Logiciels Informatiques', $company->getActivity());

        $company->setActivity('     Conseil en systèmes et logiciels informatiques');
        $this->assertEquals('Conseil En Systèmes Et Logiciels Informatiques', $company->getActivity());

        $company->setActivity('CONSEIL EN SYSTEMES ET LOGICIELS INFORMATIQUES');
        $this->assertEquals('Conseil En Systemes Et Logiciels Informatiques', $company->getActivity());

        $company->setActivity('conseil en systèmes et logiciels informatiques');
        $this->assertEquals('Conseil En Systèmes Et Logiciels Informatiques', $company->getActivity());
    }

    public function testAddressFormat(): void
    {
        $company = new Company();

        $company->setAddress('10 rue de l\'Église     ');
        $this->assertEquals('10 rue de l\'Église', $company->getAddress());

        $company->setAddress('     10 rue de l\'Église');
        $this->assertEquals('10 rue de l\'Église', $company->getAddress());

        $company->setAddress('10 RUE DE L\'ÉGLISE');
        $this->assertEquals('10 rue de l\'Église', $company->getAddress());

    }

    public function testPostalCode()
    {
        $company = new Company();

        $company->setPostalCode('79000');
        $this->assertEquals('79000', $company->getPostalCode());

        $company->setPostalCode('79000     ');
        $this->assertEquals('79000', $company->getPostalCode());

        $company->setPostalCode('     79000');
        $this->assertEquals('79000', $company->getPostalCode());
    }


    public function testCity()
    {
        $company = new Company();

        $company->setCity('PARIS     ');
        $this->assertEquals('PARIS', $company->getCity());

        $company->setCity('     PARIS');
        $this->assertEquals('PARIS', $company->getCity());

        $company->setCity('paris');
        $this->assertEquals('PARIS', $company->getCity());
    }
}
