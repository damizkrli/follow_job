<?php

namespace App\Validator\Company;

use AllowDynamicProperties;
use App\Repository\CompanyRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

#[AllowDynamicProperties] class HasUniqueCompanyValidator extends ConstraintValidator
{
    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        /* @var HasUniqueCompany $constraint */

        if (null === $value || '' === $value) {
            return;
        }

        $existingCompany = $this->companyRepository->findOneBy([
            'name' => $value,
        ]);

        if($existingCompany && $existingCompany->getId() !== $value) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
