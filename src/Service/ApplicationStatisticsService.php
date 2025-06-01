<?php

namespace App\Service;

use App\Repository\ApplicationRepository;

class ApplicationStatisticsService
{
    private ApplicationRepository $applicationRepository;

    public function __construct(ApplicationRepository $applicationRepository)
    {
        $this->applicationRepository = $applicationRepository;
    }

    public function countApplicationsToday(): int
    {
        $today = new \DateTimeImmutable('today');

        return $this->applicationRepository->countApplicationsByDate($today);
    }
}
