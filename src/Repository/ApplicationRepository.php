<?php

namespace App\Repository;

use App\Entity\Application;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Application>
 */
class ApplicationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Application::class);
    }

    public function countApplicationsByDate(\DateTimeImmutable $date): int {
        $qb = $this->createQueryBuilder('a');

        return (int) $qb
            ->select('count(a.id)')
            ->where('a.createdAt >= :startOfDay')
            ->andWhere('a.createdAt <= :endOfDay')
            ->setParameter('startOfDay', $date->setTime(0,0,0))
            ->setParameter('endOfDay', $date->modify('+1 day')->setTime(0,0,0))
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

        public function countByDateRange(\DateTimeImmutable $start, \DateTimeImmutable $end): int
    {
        $qb = $this->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->where('c.createdAt BETWEEN :start AND :end')
            ->setParameter('start', $start)
            ->setParameter('end', $end);

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    public function getApplicationsQuerySortedBySentAndIdDesc()
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.sent', 'DESC')
            ->addOrderBy('a.id', 'DESC')
            ->getQuery();
    }

    public function findApplicationsWithSearch(?array $criteria)
    {
        $qb = $this->createQueryBuilder('a');

        if (!empty($criteria['sent'])) {
            $startOfDay = (clone $criteria['sent'])->setTime(0, 0, 0);
            $endOfDay = (clone $criteria['sent'])->setTime(23, 59, 59);

            $qb->andWhere('a.sent BETWEEN :startOfDay AND :endOfDay')
            ->setParameter('startOfDay', $startOfDay)
            ->setParameter('endOfDay', $endOfDay);
        }

        if (!empty($criteria['company'])) {
            $qb->andWhere('a.company LIKE :company')
            ->setParameter('company', '%' . strtoupper($criteria['company']) . '%'); // Uppercase pour cohérence avec la base
        }

        if (!empty($criteria['jobTitle'])) {
            $qb->andWhere('LOWER(a.job_title) LIKE LOWER(:jobTitle)')
            ->setParameter('jobTitle', '%' . strtolower($criteria['jobTitle']) . '%');
        }

        if (!empty($criteria['jobboard'])) {
            $qb->andWhere('LOWER(a.jobboard) LIKE LOWER(:jobboard)')
            ->setParameter('jobboard', '%' . strtolower($criteria['jobboard']) . '%');
        }

        if (!empty($criteria['city'])) {
            $qb->andWhere('LOWER(a.city) LIKE LOWER(:city)')
            ->setParameter('city', '%' . strtolower($criteria['city']) . '%');
        }


        if (!empty($criteria['status'])) {
            $qb->andWhere('s.name = :status')
            ->setParameter('status', $criteria['status']);
            $qb->leftJoin('a.status', 's');
        }

        $qb->orderBy('a.sent', 'DESC')
        ->addOrderBy('a.id', 'DESC');

        return $qb->getQuery();
    }


}
