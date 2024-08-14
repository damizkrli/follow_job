<?php

namespace App\Validator\Application;

use App\Repository\ApplicationRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class HasUniqueApplicationValidator extends ConstraintValidator
{

    private ApplicationRepository $applicationRepository;

    public function __construct(ApplicationRepository $applicationRepository)
    {
        $this->applicationRepository = $applicationRepository;
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        /* @var HasUniqueApplicationPhp $constraint */

        if (null === $value || '' === $value) {
            return;
        }

        $existingApplication = $this->applicationRepository->findOneBy([
            'link' => $value
        ]);

        if(!$existingApplication) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}
