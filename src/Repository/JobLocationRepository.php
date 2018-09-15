<?php

namespace App\Repository;

use App\Entity\JobLocationEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method JobLocationEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method JobLocationEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method JobLocationEntity[]    findAll()
 * @method JobLocationEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobLocationRepository extends ServiceEntityRepository implements JobLocationRepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, JobLocationEntity::class);
    }
}
