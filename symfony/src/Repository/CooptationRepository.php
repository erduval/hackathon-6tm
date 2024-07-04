<?php

namespace App\Repository;

use App\Entity\Cooptation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cooptation>
 *
 * @method Cooptation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cooptation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cooptation[]    findAll()
 * @method Cooptation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CooptationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cooptation::class);
    }

    /**
     * Find cooptations by statut
     *
     * @param string $statut
     * @return Cooptation[]
     */
    public function findByStatut(string $statut): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.statut = :statut')
            ->setParameter('statut', $statut)
            ->getQuery()
            ->getResult();
    }
}
