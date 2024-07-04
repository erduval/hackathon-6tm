<?php
namespace App\Repository;

use App\Entity\CooptationOffreEmploi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CooptationOffreEmploi>
 *
 * @method CooptationOffreEmploi|null find($id, $lockMode = null, $lockVersion = null)
 * @method CooptationOffreEmploi|null findOneBy(array $criteria, array $orderBy = null)
 * @method CooptationOffreEmploi[]    findAll()
 * @method CooptationOffreEmploi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CooptationOffreEmploiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CooptationOffreEmploi::class);
    }

    /**
     * Find cooptations by cooptation ID
     *
     * @param int $cooptationId
     * @return CooptationOffreEmploi[]
     */
    public function findByCooptationId(int $cooptationId): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.cooptation = :cooptationId')
            ->setParameter('cooptationId', $cooptationId)
            ->getQuery()
            ->getResult();
    }
}

