<?php

namespace App\Repository;

use App\Entity\JobRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method JobRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method JobRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method JobRequest[]    findAll()
 * @method JobRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobRequestRepository extends ServiceEntityRepository implements JobRequestRepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, JobRequest::class);
    }

    /**
     * @param JobRequest $jobRequest
     *
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addNew(JobRequest $jobRequest): bool
    {
        $this->_em->persist($jobRequest);
        $this->_em->flush();
    }
}
