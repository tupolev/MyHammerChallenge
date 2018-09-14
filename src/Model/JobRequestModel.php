<?php

namespace App\Model;


use App\DTO\JobRequestDTO;
use App\Entity\JobRequest;
use App\Repository\JobCategoryRepositoryInterface;
use App\Repository\JobRequestRepositoryInterface;
use App\Repository\LocationRepositoryInterface;
use App\Repository\UserRepositoryInterface;

class JobRequestModel implements JobRequestModelInterface
{
    /** @var JobRequestRepositoryInterface */
    private $jobRequestRepository = null;

    /** @var UserRepositoryInterface */
    private $userRepository = null;

    /** @var JobCategoryRepositoryInterface */
    private $jobCategoryRepository = null;

    /** @var LocationRepositoryInterface */
    private $locationRepository = null;

    /**
     * @param JobRequestRepositoryInterface $jobRequestRepository
     * @param UserRepositoryInterface $userRepository
     * @param JobCategoryRepositoryInterface $jobCategoryRepository
     * @param LocationRepositoryInterface $locationRepository
     */
    public function __construct(
        JobRequestRepositoryInterface $jobRequestRepository,
        UserRepositoryInterface $userRepository,
        JobCategoryRepositoryInterface $jobCategoryRepository,
        LocationRepositoryInterface $locationRepository
    )
    {
        $this->jobRequestRepository = $jobRequestRepository;
        $this->userRepository = $userRepository;
        $this->jobCategoryRepository = $jobCategoryRepository;
        $this->locationRepository = $locationRepository;
    }

    /**
     * @param JobRequestDTO $jobRequestDTO
     * @param array $jobRequestCreationErrors
     *
     * @return bool
     */
    public function createNewJobRequest(JobRequestDTO $jobRequestDTO, array $jobRequestCreationErrors): bool
    {
        $jobRequestEntity = new JobRequest();
        $jobRequestEntity->setUser($this->userRepository->find($jobRequestDTO->getUserId()));
        $jobRequestEntity->setCategory($this->jobCategoryRepository->find($jobRequestDTO->getCategoryId()));
        $jobRequestEntity->setLocation($this->locationRepository->find($jobRequestDTO->getLocationId()));
        $jobRequestEntity->setTitle($jobRequestDTO->getTitle());
        $jobRequestEntity->setDescription($jobRequestDTO->getDescription());
        $jobRequestEntity->setDescription($jobRequestDTO->getDescription());
        $jobRequestEntity->setCreatedAt(new \DateTime());
        $jobRequestEntity->setUpdatedAt(new \DateTime());

        return $this->jobRequestRepository->addNew($jobRequestEntity);
    }
}
