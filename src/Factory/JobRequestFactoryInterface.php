<?php

namespace App\Factory;


use App\DTO\JobRequestDTO;

interface JobRequestFactoryInterface
{
    /**
     * @param string $requestBody
     *
     * @return JobRequestDTO|null
     */
    public function buildJobRequestDTO(string $requestBody): ?JobRequestDTO;
}
