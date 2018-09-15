<?php

namespace App\Repository;

use App\Entity\JobUserEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;


/**
 * @method JobUserEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method JobUserEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method JobUserEntity[]    findAll()
 * @method JobUserEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobUserRepository extends ServiceEntityRepository implements JobUserRepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, JobUserEntity::class);
    }
}
