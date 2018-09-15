<?php

namespace App\Model;


use App\DTO\JobRequestDTO;
use App\Exception\JobRequestPersistException;

interface JobRequestModelInterface
{
    /**
     * @param JobRequestDTO $jobRequestDTO
     * @param array $jobRequestCreationErrors
     * @throws JobRequestPersistException
     */
    public function createNewJobRequest(JobRequestDTO $jobRequestDTO, array $jobRequestCreationErrors);
}
