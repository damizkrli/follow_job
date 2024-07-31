<?php

namespace App\Validator\Contact;

use App\Repository\ContactRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class HasUniqueContactValidator extends ConstraintValidator
{
    /*
     * @var ContactRepository
    */
    private ContactRepository $contactRepository;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function validate($value, Constraint $constraint): void
    {
        $existingContact = $this->contactRepository->findOneBy([
            'lastname' => $value,
        ]);

        if (!$existingContact) {
            return;
        }

        if ($existingContact && $existingContact->getId() !== $value->getId()) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}