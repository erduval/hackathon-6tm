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
}
