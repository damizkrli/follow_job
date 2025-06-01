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

    public function countThisWeek(): int
    {
        $startOfWeek = (new \DateTimeImmutable())->modify('monday this week')->setTime(0, 0);
        $endOfWeek = (new \DateTimeImmutable())->modify('sunday this week')->setTime(23, 59, 59);

        return $this->applicationRepository->countByDateRange($startOfWeek, $endOfWeek);
    }

    public function countThisMonth(): int
    {
        $startOfMonth = (new \DateTimeImmutable('first day of this month'))->setTime(0, 0);
        $endOfMonth = (new \DateTimeImmutable('last day of this month'))->setTime(23, 59, 59);

        return $this->applicationRepository->countByDateRange($startOfMonth, $endOfMonth);
    }

    public function countThisYear(): int
    {
        $startOfYear = (new \DateTimeImmutable('first day of January'))->setTime(0, 0);
        $endOfYear = (new \DateTimeImmutable('last day of December'))->setTime(23, 59, 59);

        return $this->applicationRepository->countByDateRange($startOfYear, $endOfYear);
    }
}
