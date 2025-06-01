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

}
