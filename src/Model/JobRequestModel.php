<?php

namespace App\Model;


use App\DTO\JobRequestDTO;
use App\Entity\JobRequest;
use App\Exception\JobRequestPersistException;
use App\Repository\JobCategoryRepositoryInterface;
use App\Repository\JobRequestRepositoryInterface;
use App\Repository\LocationRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use Doctrine\ORM\ORMException;

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
     * @throws JobRequestPersistException
     */
    public function createNewJobRequest(JobRequestDTO $jobRequestDTO, array $jobRequestCreationErrors)
    {
        try {
            $jobRequestEntity = new JobRequest();
            $jobRequestEntity->setUser($this->userRepository->find($jobRequestDTO->getUserId()));
            $jobRequestEntity->setCategory($this->jobCategoryRepository->find($jobRequestDTO->getCategoryId()));
            $jobRequestEntity->setLocation($this->locationRepository->find($jobRequestDTO->getLocationId()));
            $jobRequestEntity->setTitle($jobRequestDTO->getTitle());
            $jobRequestEntity->setDescription($jobRequestDTO->getDescription());
            $jobRequestEntity->setRequestedDateTime($jobRequestDTO->getRequestedDateTime());
            $jobRequestEntity->setCreatedAt(new \DateTime());
            $jobRequestEntity->setUpdatedAt(new \DateTime());

            $this->jobRequestRepository->addNew($jobRequestEntity);
        } catch (ORMException $ex) {
            throw new JobRequestPersistException($ex);
        }
    }
}
