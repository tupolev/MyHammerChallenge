<?php

namespace App\Service;


use App\DTO\JobRequestDTO;
use App\Exception\JobRequestPersistException;
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

    /**
     * @param JobRequestDTO $jobRequestDTO
     * @param array $jobRequestCreationErrors
     *
     * @throws JobRequestPersistException
     */
    public function createNewJobRequest(JobRequestDTO $jobRequestDTO, array $jobRequestCreationErrors)
    {
        $this->jobRequestModel->createNewJobRequest($jobRequestDTO, $jobRequestCreationErrors);
    }
}
