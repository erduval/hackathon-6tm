<?php

namespace App\Repository;

use App\Entity\Candidature;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Candidature>
 *
 * @method Candidature|null find($id, $lockMode = null, $lockVersion = null)
 * @method Candidature|null findOneBy(array $criteria, array $orderBy = null)
 * @method Candidature[]    findAll()
 * @method Candidature[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CandidatureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Candidature::class);
    }

    /**
     * Find candidatures by coopteur
     *
     * @param int $coopteurId
     * @return Candidature[]
     */
    public function findByCoopteur(int $coopteurId): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.coopteur = :coopteurId')
            ->setParameter('coopteurId', $coopteurId)
            ->getQuery()
            ->getResult();
    }

    /**
     * Find candidatures by offre emploi
     *
     * @param int $offreEmploiId
     * @return Candidature[]
     */
    public function findByOffreEmploi(int $offreEmploiId): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.offreEmploi = :offreEmploiId')
            ->setParameter('offreEmploiId', $offreEmploiId)
            ->getQuery()
            ->getResult();
    }
}
