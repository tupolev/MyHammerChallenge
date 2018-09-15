<?php

namespace App\Model;


use App\DTO\JobRequestDTO;
use App\Entity\JobRequestEntity;
use App\Exception\JobRequestPersistException;
use App\Repository\JobCategoryRepositoryInterface;
use App\Repository\JobRequestRepositoryInterface;
use App\Repository\JobLocationRepositoryInterface;
use App\Repository\JobUserRepositoryInterface;
use Doctrine\ORM\ORMException;

class JobRequestModel implements JobRequestModelInterface
{
    /** @var JobRequestRepositoryInterface */
    private $jobRequestRepository = null;

    /** @var JobUserRepositoryInterface */
    private $jobUserRepository = null;

    /** @var JobCategoryRepositoryInterface */
    private $jobCategoryRepository = null;

    /** @var JobLocationRepositoryInterface */
    private $jobLocationRepository = null;

    /**
     * @param JobRequestRepositoryInterface $jobRequestRepository
     * @param JobUserRepositoryInterface $jobUserRepository
     * @param JobCategoryRepositoryInterface $jobCategoryRepository
     * @param JobLocationRepositoryInterface $jobLocationRepository
     */
    public function __construct(
        JobRequestRepositoryInterface $jobRequestRepository,
        JobUserRepositoryInterface $jobUserRepository,
        JobCategoryRepositoryInterface $jobCategoryRepository,
        JobLocationRepositoryInterface $jobLocationRepository
    )
    {
        $this->jobRequestRepository = $jobRequestRepository;
        $this->jobUserRepository = $jobUserRepository;
        $this->jobCategoryRepository = $jobCategoryRepository;
        $this->jobLocationRepository = $jobLocationRepository;
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
            $jobRequestEntity = new JobRequestEntity();
            $jobRequestEntity->setUser($this->jobUserRepository->find($jobRequestDTO->getUserId()));
            $jobRequestEntity->setCategory($this->jobCategoryRepository->find($jobRequestDTO->getCategoryId()));
            $jobRequestEntity->setLocation($this->jobLocationRepository->find($jobRequestDTO->getLocationId()));
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
