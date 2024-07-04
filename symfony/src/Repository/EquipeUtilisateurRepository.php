<?php

namespace App\Repository;

use App\Entity\EquipeUtilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EquipeUtilisateur>
 *
 * @method EquipeUtilisateur|null find($id, $lockMode = null, $lockVersion = null)
 * @method EquipeUtilisateur|null findOneBy(array $criteria, array $orderBy = null)
 * @method EquipeUtilisateur[]    findAll()
 * @method EquipeUtilisateur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EquipeUtilisateurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EquipeUtilisateur::class);
    }

    /**
     * Find EquipeUtilisateurs by Equipe ID.
     *
     * @param int $equipeId
     * @return EquipeUtilisateur[]
     */
    public function findByEquipeId(int $equipeId): array
    {
        return $this->createQueryBuilder('eu')
            ->andWhere('eu.equipe = :equipe')
            ->setParameter('equipe', $equipeId)
            ->getQuery()
            ->getResult();
    }

    /**
     * Find EquipeUtilisateurs by Utilisateur ID.
     *
     * @param int $utilisateurId
     * @return EquipeUtilisateur[]
     */
    public function findByUtilisateurId(int $utilisateurId): array
    {
        return $this->createQueryBuilder('eu')
            ->andWhere('eu.utilisateur = :utilisateur')
            ->setParameter('utilisateur', $utilisateurId)
            ->getQuery()
            ->getResult();
    }
}
