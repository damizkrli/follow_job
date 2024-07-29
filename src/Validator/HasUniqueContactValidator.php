<?php

namespace App\Validator;

use App\Repository\ContactRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class HasUniqueContactValidator extends ConstraintValidator
{
    private ContactRepository $contactRepository;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        $existingContact = $this->contactRepository->findOneBy([
            'lastname' => $value,
        ]);

        if (!$existingContact) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ string }}', $value)
            ->addViolation();
    }
}