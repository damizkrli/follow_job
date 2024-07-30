<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Validator as AcmeAssert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContactRepository")
 * @HasUniqueContact
 */
#[ORM\Entity(repositoryClass: ContactRepository::class)]
#[UniqueEntity(
    fields: ['firstname', 'lastname', 'email'],
    message: 'Ce contact existe déjà en base de données. Veuillez modifier votre saisie.',
)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 15)]
    private ?string $firstname = null;

    #[ORM\Column(length: 15)]
    #[AcmeAssert\HasUniqueContact]
    private ?string $lastname = null;

    #[ORM\Column(length: 25)]
    private ?string $email = null;

    #[ORM\Column]
    private ?int $phone = null;

    #[ORM\Column(length: 50)]
    private ?string $social = null;

    public function __toString(): string
    {
        return $this->lastname;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = trim(ucfirst($firstname));

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = trim(ucfirst($lastname));

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $email = trim(strtolower($email));

        $this->email = filter_var($email, FILTER_VALIDATE_EMAIL);

        if (!$email) {
             echo 'Votre email n\'est pas valide. Merci de renseigner une adresse valide.';
        }

        return $this;
    }

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(int $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getSocial(): ?string
    {
        return $this->social;
    }

    public function setSocial(string $social): static
    {
        $this->social = $social;

        return $this;
    }
}
