<?php

namespace App\Repository;

use App\Entity\ClassementEquipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ClassementEquipe|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClassementEquipe|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClassementEquipe[]    findAll()
 * @method ClassementEquipe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClassementEquipeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClassementEquipe::class);
    }
}
