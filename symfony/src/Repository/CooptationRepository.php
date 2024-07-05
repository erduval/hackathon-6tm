<?php

// src/Repository/CooptationRepository.php
namespace App\Repository;

use App\Entity\Cooptation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CooptationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cooptation::class);
    }
}
