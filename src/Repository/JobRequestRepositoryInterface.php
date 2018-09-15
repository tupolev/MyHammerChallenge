<?php

namespace App\Repository;

use App\Entity\JobRequest;

interface JobRequestRepositoryInterface
{
    /**
     * @param JobRequest $jobRequest
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addNew(JobRequest $jobRequest);
}
