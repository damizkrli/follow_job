<?php

namespace App\Validator\Company;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PostalZipCodeFrenchFormatValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        /* @var PostalZipCodeFrenchFormat $constraint */

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_numeric($value) || strlen($value) !== 5 || !ctype_digit($value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }

    }
}
