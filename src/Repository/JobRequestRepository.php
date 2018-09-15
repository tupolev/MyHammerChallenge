<?php

namespace App\Repository;

use App\Entity\JobRequestEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method JobRequestEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method JobRequestEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method JobRequestEntity[]    findAll()
 * @method JobRequestEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobRequestRepository extends ServiceEntityRepository implements JobRequestRepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, JobRequestEntity::class);
    }

    /**
     * @param JobRequestEntity $jobRequest
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addNew(JobRequestEntity $jobRequest)
    {
        $this->_em->persist($jobRequest);
        $this->_em->flush();
    }
}
