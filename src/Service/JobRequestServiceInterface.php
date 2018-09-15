<?php

namespace App\Service;


use App\DTO\JobRequestDTO;
use App\Exception\JobRequestPersistException;

interface JobRequestServiceInterface
{
    /**
     * @param JobRequestDTO $jobRequestDTO
     * @param array $jobRequestCreationErrors
     * @throws JobRequestPersistException
     */
    public function createNewJobRequest(JobRequestDTO $jobRequestDTO, array $jobRequestCreationErrors);
}
