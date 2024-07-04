<?php

namespace App\Repository;

use App\Entity\Classement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Classement>
 *
 * @method Classement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Classement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Classement[]    findAll()
 * @method Classement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClassementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Classement::class);
    }

    /**
     * Find classements by equipe
     *
     * @param int $equipeId
     * @return Classement[]
     */
    public function findByEquipe(int $equipeId): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.equipe = :equipeId')
            ->setParameter('equipeId', $equipeId)
            ->getQuery()
            ->getResult();
    }

    /**
     * Find classements by position
     *
     * @param int $position
     * @return Classement[]
     */
    public function findByPosition(int $position): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.position = :position')
            ->setParameter('position', $position)
            ->getQuery()
            ->getResult();
    }
}
