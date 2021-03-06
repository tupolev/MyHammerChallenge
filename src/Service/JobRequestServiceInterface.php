<?php

namespace App\Service;


use App\DTO\JobRequestDTO;
use App\Exception\JobRequestPersistException;

interface JobRequestServiceInterface
{
    /**
     * @param JobRequestDTO $jobRequestDTO
     * @throws JobRequestPersistException
     */
    public function createNewJobRequest(JobRequestDTO $jobRequestDTO);
}
