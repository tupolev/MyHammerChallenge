<?php

namespace App\Tests\Validator;

use App\DTO\JobRequestDTO;
use App\Factory\JobRequestFactoryInterface;
use App\Model\JobRequestModelInterface;
use App\Tests\App\Context\JobRequestContext;
use App\Validator\JobRequestPayloadValidator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use TypeError;
use Zalas\Injector\PHPUnit\Symfony\TestCase\SymfonyTestContainer;
use Zalas\Injector\PHPUnit\TestCase\ServiceContainerTestCase;

/** @covers \App\Validator\JobRequestPayloadValidator */
class JobRequestValidatorTest extends KernelTestCase implements ServiceContainerTestCase
{
    use SymfonyTestContainer;
    use JobRequestContext;

    /** @covers \App\Validator\JobRequestPayloadValidator::isValidRequestPayload */
    public function testCreateNewJobRequest()
    {
        $jobRequestValidationErrors = [];
        $isJobRequestValid = (new JobRequestPayloadValidator())->isValidRequestPayload(
            json_encode(self::$validPayload),
            $jobRequestValidationErrors
        );

        $this->assertTrue($isJobRequestValid);
        $this->assertEmpty($jobRequestValidationErrors);
    }

    /** @covers \App\Validator\JobRequestPayloadValidator::isValidRequestPayload */
    public function testCreateNewJobRequestNotJsonPayload()
    {
        $jobRequestValidationErrors = [];
        $isJobRequestValid = (new JobRequestPayloadValidator())->isValidRequestPayload(
            "wrong payload",
            $jobRequestValidationErrors
        );
        $this->assertFalse($isJobRequestValid);
        $this->assertArrayHasKey("form", $jobRequestValidationErrors);
        $this->assertEquals(json_last_error() . "//" . json_last_error_msg(), $jobRequestValidationErrors["form"]);
    }

    /** @covers \App\Validator\JobRequestPayloadValidator::isValidRequestPayload */
    public function testCreateNewJobRequestMissingField()
    {
        $jobRequestValidationErrors = [];
        $modifiedPayload = self::$validPayload;
        unset($modifiedPayload["userId"]);
        $isJobRequestValid = (new JobRequestPayloadValidator())->isValidRequestPayload(
            json_encode($modifiedPayload),
            $jobRequestValidationErrors
        );
        $this->assertFalse($isJobRequestValid);
        $this->assertArrayHasKey("userId", $jobRequestValidationErrors);
        $this->assertEquals("Field is missing in the request", $jobRequestValidationErrors["userId"]);
    }

    /** @covers \App\Validator\JobRequestPayloadValidator::isValidRequestPayload */
    public function testCreateNewJobRequestWrongRequestedDatetime()
    {
        $jobRequestValidationErrors = [];
        $modifiedPayload = self::$validPayload;
        $modifiedPayload["requestedDateTime"] = "invalid date";
        $isJobRequestValid = (new JobRequestPayloadValidator())->isValidRequestPayload(
            json_encode($modifiedPayload),
            $jobRequestValidationErrors
        );
        $this->assertFalse($isJobRequestValid);
        $this->assertArrayHasKey("requestedDateTime", $jobRequestValidationErrors);
        $this->assertEquals("Field value is not a datetime in valid ISO format and/or is in the past", $jobRequestValidationErrors["requestedDateTime"]);
    }    /** @covers \App\Validator\JobRequestPayloadValidator::isValidRequestPayload */

    public function testCreateNewJobRequestInvalidLocationId()
    {
        $jobRequestValidationErrors = [];
        $modifiedPayload = self::$validPayload;
        $modifiedPayload["locationId"] = "invalid";
        $isJobRequestValid = (new JobRequestPayloadValidator())->isValidRequestPayload(
            json_encode($modifiedPayload),
            $jobRequestValidationErrors
        );
        $this->assertFalse($isJobRequestValid);
        $this->assertArrayHasKey("locationId", $jobRequestValidationErrors);
        $this->assertEquals("LocationId must be numeric", $jobRequestValidationErrors["locationId"]);
    }

    /** @covers \App\Validator\JobRequestPayloadValidator::isValidRequestPayload */
    public function testCreateNewJobRequestWrongTitleAndDescriptionLength()
    {
        $jobRequestValidationErrors = [];
        $modifiedPayload = self::$validPayload;
        $modifiedPayload["title"] = "tiny";
        $modifiedPayload["description"] = "a way too short descriptipn";
        $isJobRequestValid = (new JobRequestPayloadValidator())->isValidRequestPayload(
            json_encode($modifiedPayload),
            $jobRequestValidationErrors
        );
        $this->assertFalse($isJobRequestValid);
        $this->assertArrayHasKey("title", $jobRequestValidationErrors);
        $this->assertArrayHasKey("description", $jobRequestValidationErrors);
        $this->assertEquals("Title length must be between 5 and 50 chars", $jobRequestValidationErrors["title"]);
        $this->assertEquals("Description must be longer than 100 chars", $jobRequestValidationErrors["description"]);
    }
}
