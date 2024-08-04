<?php

namespace App\Validator\JobBoard;

use AllowDynamicProperties;
use App\Repository\JobBoardRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

#[AllowDynamicProperties] class HasSpacesInJobboardNameValidator extends ConstraintValidator
{
    public function __construct(JobBoardRepository $jobBoardRepository)
    {
        $this->jobBoardRepository = $jobBoardRepository;
    }

    public function validate(mixed $value, Constraint $constraint)
    {
        /* @var $constraint HasSpacesInJobboardName */

        if (null === $value || '' === $value) {
            return;
        }

        if(strlen($value) < 9){
            return;
        }

        if (str_contains($value, ' ')) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}