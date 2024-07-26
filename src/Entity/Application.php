<?php

namespace App\Entity;

use App\Repository\ApplicationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ApplicationRepository::class)]
class Application
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $job_title = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $sent = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $response = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $link = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $note = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true)]
    private ?Contact $contact = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true)]
    private ?JobBoard $job_board = null;

    #[ORM\Column(length: 10)]
    private ?string $statut = null;

    /**
     * @var Collection<int, Company>
     */
    #[ORM\ManyToMany(targetEntity: Company::class)]
    private Collection $company;

    public function __construct()
    {
        $this->company = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(Contact $contact): static
    {
        $this->contact = $contact;

        return $this;
    }

    public function getJobBoard(): ?JobBoard
    {
        return $this->job_board;
    }

    public function setJobBoard(JobBoard $job_board): static
    {
        $this->job_board = $job_board;

        return $this;
    }

    public function getJobTitle(): ?string
    {
        return $this->job_title;
    }

    public function setJobTitle(string $job_title): static
    {
        $this->job_title = $job_title;

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
        $this->link = $link;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * @return Collection<int, Company>
     */
    public function getCompany(): Collection
    {
        return $this->company;
    }

    public function addCompany(Company $company): static
    {
        if (!$this->company->contains($company)) {
            $this->company->add($company);
        }

        return $this;
    }

    public function removeCompany(Company $company): static
    {
        $this->company->removeElement($company);

        return $this;
    }

}