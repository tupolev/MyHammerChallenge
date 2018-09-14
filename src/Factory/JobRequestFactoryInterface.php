<?php

namespace App\Factory;


use App\DTO\JobRequestDTO;

interface JobRequestFactoryInterface
{
    /**
     * @param string $requestBody
     * @param array $jobRequestParseErrors
     *
     * @return JobRequestDTO|null
     */
    public function __invoke(string $requestBody, array &$jobRequestParseErrors): ?JobRequestDTO;
}
