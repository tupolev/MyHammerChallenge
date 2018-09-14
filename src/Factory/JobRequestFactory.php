<?php

namespace App\Factory;

use App\DTO\JobRequestDTO;

class JobRequestFactory implements JobRequestFactoryInterface
{
    const PARSE_JSON_ASSOC = true;

    const EXPECTED_FIELDS = [
        "userId",
        "locationId",
        "categoryId",
        "title",
        "description",
        "requestedDateTime",
    ];

    /**
     * @param string $requestBody
     * @param array $jobRequestParseErrors
     *
     * @return JobRequestDTO|null
     */
    public function __invoke(string $requestBody, array &$jobRequestParseErrors): ?JobRequestDTO
    {
        $parsedRequest = json_decode($requestBody, self::PARSE_JSON_ASSOC);
        if (!$parsedRequest) {
            $jobRequestParseErrors["form"] = json_last_error() . "//" . json_last_error_msg();

            return null;
        }

        $missingFields = array_diff(self::EXPECTED_FIELDS, array_keys($parsedRequest));
        if (!empty($missingFields)) {
            foreach ($missingFields as $missingField) {
                $jobRequestParseErrors[$missingField]= "Field is missing in the request";
            }

            return null;
        }

        $requestedDateTime = \DateTime::createFromFormat(\DateTime::ISO8601, $parsedRequest["requestedDateTime"]);
        if (!$requestedDateTime) {
            $jobRequestParseErrors["requestedDateTime"]= "Field value is not a datetime in valid ISO format";

            return null;
        }

        $jobRequestDTO = new JobRequestDTO();
        $jobRequestDTO->setUserId($parsedRequest["userId"]);
        $jobRequestDTO->setLocationId($parsedRequest["locationId"]);
        $jobRequestDTO->setCategoryId($parsedRequest["categoryId"]);
        $jobRequestDTO->setTitle($parsedRequest["title"]);
        $jobRequestDTO->setDescription($parsedRequest["description"]);
        $jobRequestDTO->setRequestedDateTime($requestedDateTime);

        return $jobRequestDTO;
    }
}
