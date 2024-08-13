<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Company as CompanyValidator;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
#[UniqueEntity(
    fields: ['name'],
    message: '{{ value }} existe déjà en bas de données. Veuillez enregistrer une nouvelle entreprise.',
    groups: ['unique_name']
)]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(
        message: 'Cette valeur ne doit pas être vide.',
    )]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: 'Cette valeur devrait comporter {{ limit }} caractères ou plus.',
        maxMessage: 'Cette valeur devrait comporter {{ limit }} caractères ou moins.'
    )]
    #[CompanyValidator\HasUniqueCompany]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(
        message: 'Cette valeur ne doit pas être vide.'
    )]
    #[Assert\Length(
        min: 2,
        max: 255,
    )]
    private ?string $activity = null;

    #[ORM\Column(length: 75, nullable: true)]
    #[Assert\Length(
        min: 2,
        max: 75,
        minMessage: 'Cette valeur devrait comporter {{ limit }} caractères ou plus.',
        maxMessage: 'Cette valeur devrait comporter {{ limit }} caractères ou moins.',
    )]
    private ?string $address = null;

    #[ORM\Column(length: 5, nullable: true)]
    #[Assert\Length(
        exactly: 5,
        exactMessage: 'Cette valeur doit comporter exactement {{ limit }} caractères.'
    )]
    #[Assert\Positive(
        message: 'Cette valeur doit être positive.'
    )]
    #[CompanyValidator\PostalZipCodeFrenchFormat]
    private ?int $postalCode = null;

    #[ORM\Column(length: 75, nullable: true)]
    #[Assert\Length(
        min: 2,
        max: 75,
        minMessage: 'Cette valeur devrait comporter {{ limit }} caractères ou plus.',
        maxMessage: 'Cette valeur devrait comporter {{ limit }} caractères ou moins.',
    )]
    private ?string $city = null;

    public function __toString(): string
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = trim(ucwords($name));

        return $this;
    }

    public function getActivity(): ?string
    {
        return $this->activity;
    }

    public function setActivity(string $activity): static
    {
        $this->activity = trim(ucwords(strtolower($activity)));

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = trim(strtolower($address));

        return $this;
    }

    public function getPostalCode(): ?int
    {
        return $this->postalCode;
    }

    public function setPostalCode(int $postalCode): static
    {
        $this->postalCode = trim($postalCode);

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = trim(strtoupper($city));

        return $this;
    }
}
