<?php

namespace App\Repository;

use App\Entity\JobRequestEntity;

interface JobRequestRepositoryInterface
{
    /**
     * @param JobRequestEntity $jobRequest
     *
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addNew(JobRequestEntity $jobRequest);
}
