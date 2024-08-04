<?php

namespace App\Validator\JobBoard;

use App\Repository\JobBoardRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class HasUniqueJobboardValidator extends ConstraintValidator
{

    private JobBoardRepository $jobBoardRepository;

    public function __construct(JobBoardRepository $jobBoardRepository)
    {
        $this->jobBoardRepository = $jobBoardRepository;
    }


    public function validate(mixed $value, Constraint $constraint)
    {

        $existingJobboard = $this->jobBoardRepository->findOneBy([
            'name' => $value,
        ]);

        if (!$existingJobboard) {
            return;
        }

        if ($existingJobboard->getId() !== $value) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}