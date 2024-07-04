<?php

namespace App\Repository;

use App\Entity\Equipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Equipe>
 *
 * @method Equipe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Equipe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Equipe[]    findAll()
 * @method Equipe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EquipeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Equipe::class);
    }

    /**
     * Find teams by name
     *
     * @param string $nom
     * @return Equipe[]
     */
    public function findByNom(string $nom): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.nom = :nom')
            ->setParameter('nom', $nom)
            ->getQuery()
            ->getResult();
    }

    /**
     * Find all teams with a name containing a specific substring
     *
     * @param string $nom
     * @return Equipe[]
     */
    public function findByNomContaining(string $nom): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.nom LIKE :nom')
            ->setParameter('nom', '%' . $nom . '%')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find all teams sorted by total points in descending order
     *
     * @return Equipe[]
     */
    public function findAllOrderByTotalPointsDesc(): array
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.totalPoints', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
