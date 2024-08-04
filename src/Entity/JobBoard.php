<?php

namespace App\Entity;

use App\Repository\JobBoardRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\JobBoard as HasUniqueJobboard;
use App\Validator\JobBoard as HasSpacesInJobboardName;

#[ORM\Entity(repositoryClass: JobBoardRepository::class)]
#[UniqueEntity(
    fields: ['name'],
    message: '',
)]
class JobBoard
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    #[HasUniqueJobboard\HasUniqueJobboard()]
    #[HasSpacesInJobboardName\HasSpacesInJobboardName()]
    #[Assert\NotBlank(
        message: 'Cette valeur ne doit pas être vide',
    )]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'Cette valeur devrait comporter {{ limit }} caractères ou plus.',
        maxMessage: 'Cette valeur devrait comporter {{ limit }} caractères ou moins.'
    )]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(
        message: 'Cette valeur ne doit pas être vide'
    )]
    #[Assert\Url(
        message: 'Cette valeur n\'est pas une URL valide'
    )]
    #[Assert\Length(
        min: '10',
        max: '50',
        minMessage: 'Cette valeur devrait comporter {{ limit }} caractères ou plus.',
        maxMessage: 'Cette valeur devrait comporter {{ limit }} caractères ou moins.',
    )]
    private ?string $link = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotNull(
        message: 'Cette valeur ne doit pas être nulle.'
    )]
    private ?bool $profile = null;

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
        $this->name = trim(ucwords(strtolower($name)));

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

    public function isProfile(): ?bool
    {
        return $this->profile;
    }

    public function setProfile(bool $profile): static
    {
        $this->profile = $profile;

        return $this;
    }
}
