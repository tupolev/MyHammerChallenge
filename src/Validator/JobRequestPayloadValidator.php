<?php

namespace App\Validator;


class JobRequestPayloadValidator
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
     * @param null|string $jsonRequestBody
     * @param array $jobRequestValidateErrors
     *
     * @return bool
     */
    public function isValidRequestPayload(?string $jsonRequestBody, array &$jobRequestValidateErrors): bool
    {
        //overall payload integrity validation
        $parsedRequest = json_decode($jsonRequestBody, self::PARSE_JSON_ASSOC);
        if (!$parsedRequest) {
            $jobRequestValidateErrors["form"] = json_last_error() . "//" . json_last_error_msg();

            return false;
        }

        //payload structure validation
        $missingFields = array_diff(self::EXPECTED_FIELDS, array_keys($parsedRequest));
        if (!empty($missingFields)) {
            foreach ($missingFields as $missingField) {
                $jobRequestValidateErrors[$missingField]= "Field is missing in the request";
            }

            return false;

        }

        //field by field validations

        foreach ($parsedRequest as $field => $value) {
            if (strlen($value) === 0) {
                $jobRequestValidateErrors[$field]= "Field cannot be empty.";
            }
        }

        $requestedDateTime = \DateTime::createFromFormat(\DateTime::ISO8601, $parsedRequest["requestedDateTime"]);
        if (!$requestedDateTime || $requestedDateTime <= new \DateTime()) {
            $jobRequestValidateErrors["requestedDateTime"]= "Field value is not a datetime in valid ISO format and/or is in the past";
        }

        $titleLength = strlen($parsedRequest["title"]);
        if ($titleLength < 5 || $titleLength > 50) {
            if (!array_key_exists("title", $jobRequestValidateErrors)) {
                $jobRequestValidateErrors["title"] = "Title length must be between 5 and 50 chars";
            }
        }

        if (strlen($parsedRequest["description"]) < 100) {
            if (!array_key_exists("description", $jobRequestValidateErrors)) {
                $jobRequestValidateErrors["description"] = "Description must be longer than 100 chars";
            }
        }

        if (!is_numeric($parsedRequest["locationId"])) {
            if (!array_key_exists("locationId", $jobRequestValidateErrors)) {
                $jobRequestValidateErrors["locationId"] = "LocationId must be numeric";
            }
        }

        return count($jobRequestValidateErrors) === 0;
    }
}
