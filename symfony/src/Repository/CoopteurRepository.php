<?php

namespace App\Repository;

use App\Entity\Coopteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Coopteur>
 *
 * @method Coopteur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Coopteur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Coopteur[]    findAll()
 * @method Coopteur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoopteurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Coopteur::class);
    }

    /**
     * Find coopteurs by points
     *
     * @param int $points
     * @return Coopteur[]
     */
    public function findByPoints(int $points): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.points = :points')
            ->setParameter('points', $points)
            ->getQuery()
            ->getResult();
    }

    /**
     * Find all coopteurs with points greater than a given value
     *
     * @param int $points
     * @return Coopteur[]
     */
    public function findWithPointsGreaterThan(int $points): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.points > :points')
            ->setParameter('points', $points)
            ->getQuery()
            ->getResult();
    }

    /**
     * Find all coopteurs sorted by points in descending order
     *
     * @return Coopteur[]
     */
    public function findAllOrderByPointsDesc(): array
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.points', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
