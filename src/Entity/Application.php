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

    #[ORM\Column(length: 80)]
    #[Assert\NotBlank(
        message: "Le nom du poste est obligatoire."
    )]
    #[Assert\Length(
        min: 2,
        max: 80,
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

    #[ORM\Column(length: 100)]
    private ?string $company = null;

    #[ORM\Column(length: 100)]
    private ?string $jobboard = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: 'string', length: 70, nullable: true)]
    #[Assert\Length(
        min: 2,
        max: 70,
        minMessage: 'Le nom de la ville doit faire au moins {{ limit }} caractères.',
        maxMessage: 'Le nom de la ville ne peut pas dépasser {{ limit }} caractères.'
    )]
    private ?string $city = null;

    #[ORM\ManyToOne(targetEntity: Status::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Status $status = null;

    public function __construct() {
        $this->sent = new \DateTime();

	if ($this->createdAt === null) {
            $this->createdAt = new \DateTimeImmutable();
    	}
    }

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

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(string $company): static
    {
        $this->company = strtoupper(trim($company));

        return $this;
    }

    public function getJobboard(): ?string
    {
        return $this->jobboard;
    }

    public function setJobboard(string $jobboard): static
    {
        $this->jobboard = ucwords(strtolower(trim($jobboard)));

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;
        return $this;
    }

}
