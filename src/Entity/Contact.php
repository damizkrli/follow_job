<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Contact as PhoneLengthValidator;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ContactRepository")
 * @HasUniqueContact
 */
#[ORM\Entity(repositoryClass: ContactRepository::class)]
#[UniqueEntity(
    fields : ['firstname', 'lastname', 'email'],
    message: 'Ce contact existe déjà en base de données. Veuillez modifier votre saisie.',
)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 15)]
    #[Assert\NotBlank(
        message: "Cette valeur ne doit pas être vide."
    )]
    #[Assert\Length(
        min       : 3,
        max       : 15,
        minMessage: 'Cette valeur devrait comporter {{ limit }} caractères ou plus.',
        maxMessage: 'Cette valeur devrait comporter {{ limit }} caractères ou moins.'
    )]
    private ?string $firstname = null;

    #[ORM\Column(length: 15)]
    #[Assert\NotBlank(
        message: "Cette valeur ne doit pas être vide."
    )]
    #[Assert\Length(
        min       : 3,
        max       : 15,
        minMessage: 'Cette valeur devrait comporter {{ limit }} caractères ou plus.',
        maxMessage: 'Cette valeur devrait comporter {{ limit }} caractères ou moins.'
    )]
    private ?string $lastname = null;

    #[ORM\Column(length: 25)]
    #[Assert\NotBlank(
        message: "Cette valeur ne doit pas être vide."
    )]
    #[Assert\Email(
        message: "Cette valeur n'est pas une adresse électronique valide.",
        mode   : 'html5-allow-no-tld'
    )]
    #[Assert\Length(
        min       : 10,
        max       : 30,
        minMessage: 'Cette valeur devrait comporter {{ limit }} caractères ou plus.',
        maxMessage: 'Cette valeur devrait comporter {{ limit }} caractères ou moins.',
    )]
    private ?string $email = null;

    #[ORM\Column(length: 13)]
    #[Assert\NotBlank(
        message: 'Cette valeur ne doit pas être vide.'
    )]
    #[Assert\Positive(
        message: 'Cette valeur doit être positive.'
    )]
    #[PhoneLengthValidator\HasPhoneNumberHasNineDigits]
    private ?string $phone = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(
        message: "Cette valeur ne doit pas être vide."
    )]
    #[Assert\Url(
        message: "Cette valeur n'est pas une URL valide."
    )]
    #[Assert\Length(
        min       : 10,
        max       : 50,
        minMessage: 'Cette valeur devrait comporter {{ limit }} caractères ou plus.',
        maxMessage: 'Cette valeur devrait comporter {{ limit }} caractères ou moins.'
    )]
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

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $characters = "0\''";

        $this->phone = ltrim(($phone), $characters);

        return $this;
    }

    public function getSocial(): ?string
    {
        return $this->social;
    }

    public function setSocial(string $social): static
    {

        $social = strtolower(trim($social));

        $this->social = $social;

        return $this;
    }

}
