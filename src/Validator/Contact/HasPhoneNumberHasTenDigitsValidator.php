<?php

namespace App\Validator\Contact;

use App\Repository\ContactRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class HasPhoneNumberHasTenDigitsValidator extends ConstraintValidator
{
    private ContactRepository $contactRepository;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!is_string($value) || strlen($value) !== 10 || !ctype_digit($value)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}