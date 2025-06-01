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

    public function countApplicationByDate(\DateTimeImmutable $date): int {
        $qb = $this->createQueryBuilder('a');

        return (int) $qb
            ->select('count(a.id)')
            ->where('a.createdAt' >= ':startOfDay')
            ->andWhere('a.createdAt' <= ':endOfDay')
            ->setParameter('startOfDay', $date->setTime(0,0,0))
            ->setParameter('endOfDay', $date->modify('+1 day')->setTime(0,0,0))
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

}
