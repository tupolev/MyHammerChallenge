<?php

namespace App\Model;


use App\DTO\JobRequestDTO;
use App\Exception\JobRequestPersistException;

interface JobRequestModelInterface
{
    /**
     * @param JobRequestDTO $jobRequestDTO
     * @throws JobRequestPersistException
     */
    public function createNewJobRequest(JobRequestDTO $jobRequestDTO);
}
