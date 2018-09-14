<?php

namespace App\Service;


use App\DTO\JobRequestDTO;

interface JobRequestServiceInterface
{
    /**
     * @param JobRequestDTO $jobRequestDTO
     * @param array $jobRequestCreationErrors
     * @return bool
     */
    public function createNewJobRequest(JobRequestDTO $jobRequestDTO, array $jobRequestCreationErrors): bool;
}
