<?php

namespace App\Repository;

use App\Entity\JobCategoryEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method JobCategoryEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method JobCategoryEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method JobCategoryEntity[]    findAll()
 * @method JobCategoryEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobCategoryRepository extends ServiceEntityRepository implements JobCategoryRepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, JobCategoryEntity::class);
    }
}
