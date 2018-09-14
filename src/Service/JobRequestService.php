<?php

namespace App\Service;


use App\DTO\JobRequestDTO;
use App\Model\JobRequestModelInterface;

class JobRequestService implements JobRequestServiceInterface
{
    /** @var JobRequestModelInterface */
    private $jobRequestModel = null;

    /**
     * @param JobRequestModelInterface $jobRequestModel
     */
    public function __construct(JobRequestModelInterface $jobRequestModel)
    {
        $this->jobRequestModel = $jobRequestModel;
    }

    public function createNewJobRequest(JobRequestDTO $jobRequestDTO, array $jobRequestCreationErrors): bool
    {
        $this->jobRequestModel->createNewJobRequest($jobRequestDTO, $jobRequestCreationErrors);
    }
}
