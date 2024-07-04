<?php
namespace App\Repository;

use App\Entity\RH;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RH>
 *
 * @method RH|null find($id, $lockMode = null, $lockVersion = null)
 * @method RH|null findOneBy(array $criteria, array $orderBy = null)
 * @method RH[]    findAll()
 * @method RH[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RHRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RH::class);
    }

    /**
     * Find RH by Utilisateur.
     *
     * @param int $utilisateurId
     * @return RH|null
     */
    public function findOneByUtilisateur(int $utilisateurId): ?RH
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.utilisateur = :utilisateurId')
            ->setParameter('utilisateurId', $utilisateurId)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Find all RHs ordered by their ID.
     *
     * @return RH[]
     */
    public function findAllOrderedById(): array
    {
        return $this->createQueryBuilder('r')
            ->orderBy('r.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
}

