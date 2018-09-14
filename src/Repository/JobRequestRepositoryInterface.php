<?php

namespace App\Repository;

use App\Entity\JobRequest;

interface JobRequestRepositoryInterface
{
    public function addNew(JobRequest $jobRequest): bool;
}
