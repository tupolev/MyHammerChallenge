<?php

namespace App\Factory;

use App\DTO\JobRequestDTO;

class JobRequestFactory implements JobRequestFactoryInterface
{
    const PARSE_JSON_ASSOC = true;

    /**
     * @param string $requestBody
     *
     * @return JobRequestDTO|null
     */
    public function buildJobRequestDTO(string $requestBody): ?JobRequestDTO
    {
        $parsedRequest = json_decode($requestBody, self::PARSE_JSON_ASSOC);

        $jobRequestDTO = new JobRequestDTO();
        $jobRequestDTO->setUserId($parsedRequest["userId"]);
        $jobRequestDTO->setLocationId($parsedRequest["locationId"]);
        $jobRequestDTO->setCategoryId($parsedRequest["categoryId"]);
        $jobRequestDTO->setTitle($parsedRequest["title"]);
        $jobRequestDTO->setDescription($parsedRequest["description"]);
        $jobRequestDTO->setRequestedDateTime(\DateTime::createFromFormat(\DateTime::ISO8601, $parsedRequest["requestedDateTime"]));

        return $jobRequestDTO;
    }
}
