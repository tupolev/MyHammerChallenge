<?php

namespace App\Model;


use App\DTO\JobRequestDTO;
use App\Entity\JobRequest;
use App\Exception\JobRequestPersistException;

/**
 * @method JobRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method JobRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method JobRequest[]    findAll()
 * @method JobRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface JobRequestModelInterface
{
    /**
     * @param JobRequestDTO $jobRequestDTO
     * @param array $jobRequestCreationErrors
     * @throws JobRequestPersistException
     */
    public function createNewJobRequest(JobRequestDTO $jobRequestDTO, array $jobRequestCreationErrors);
}
