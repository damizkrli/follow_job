<?php

namespace App\Entity;

use App\Repository\ApplicationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ApplicationRepository::class)]
#[UniqueEntity(
    fields: ['link'],
    message: "Vous avez déjà postulé à cette annonce."
)]
class Application
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 40)]
    #[Assert\NotBlank(
        message: "Le nom du poste est obligatoire."
    )]
    #[Assert\Length(
        min: 2,
        max: 40,
        minMessage: 'Cette valeur devrait comporter {{ limit }} caractères ou plus.',
        maxMessage: 'Cette valeur devrait comporter {{ limit }} caractères ou moins.'
    )]
    private ?string $job_title = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: false)]
    #[Assert\NotNull(
        message: "La date d'envoi ne peut pas être vide."
    )]
    #[Assert\Type("\DateTimeInterface",
        message: "La date d'envoi doit être une date valide."
    )]
    #[Assert\NotBlank(
        message: 'Veuillez renseigner une date d\'envoi.',
    )]
    private ?\DateTimeInterface $sent = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $response = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(
        message: 'Veuillez renseigner un lien vers l\'application.',
    )]
    #[Assert\Length(
        min: 2,
        max: 2100,
        minMessage: 'Cette valeur devrait comporter {{ limit }} caractères ou plus.',
        maxMessage: 'Cette valeur devrait comporter {{ limit }} caractères ou moins.'
    )]
    #[Assert\Url(
        message: 'Veuillez renseigner une url valide.',
    )]
    private ?string $link = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\Length(
        min: 2,
        max: 5000,
        minMessage: 'Cette valeur devrait comporter {{ limit }} caractères ou plus.',
        maxMessage: 'Cette valeur devrait comporter {{ limit }} caractères ou moins.'
    )]
    private ?string $note = null;

    #[ORM\Column(length: 10)]
    #[Assert\NotBlank(
        message: 'Veuillez renseigner un statut.',
    )]
    private ?string $statut = "Envoyée";

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?Company $company = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?Contact $contact = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?JobBoard $job_board = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJobTitle(): ?string
    {
        return $this->job_title;
    }

    public function setJobTitle(string $job_title): static
    {
        $this->job_title = trim(ucwords($job_title));

        return $this;
    }

    public function getSent(): ?\DateTimeInterface
    {
        return $this->sent;
    }

    public function setSent(\DateTimeInterface $sent): static
    {
        $this->sent = $sent;

        return $this;
    }

    public function getResponse(): ?\DateTimeInterface
    {
        return $this->response;
    }

    public function setResponse(?\DateTimeInterface $response): static
    {
        $this->response = $response;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): static
    {
        $this->link = trim(strtolower($link));

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): static
    {
        $this->note = ucfirst(trim(strtolower($note)));

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): void
    {
        $this->statut = trim(strtoupper($statut));
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): static
    {
        $this->contact = $contact;

        return $this;
    }

    public function getJobBoard(): ?JobBoard
    {
        return $this->job_board;
    }

    public function setJobBoard(?JobBoard $job_board): static
    {
        $this->job_board = $job_board;

        return $this;
    }

}
