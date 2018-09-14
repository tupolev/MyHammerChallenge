<?php

namespace App\Model;


use App\DTO\JobRequestDTO;

interface JobRequestModelInterface
{
    public function createNewJobRequest(JobRequestDTO $jobRequestDTO, array $jobRequestCreationErrors): bool;

}
