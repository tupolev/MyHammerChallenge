<?php

namespace App\Tests\Factory;

use App\DTO\JobRequestDTO;
use App\Factory\JobRequestFactoryInterface;
use App\Model\JobRequestModelInterface;
use App\Tests\App\Context\JobRequestContext;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use TypeError;
use Zalas\Injector\PHPUnit\Symfony\TestCase\SymfonyTestContainer;
use Zalas\Injector\PHPUnit\TestCase\ServiceContainerTestCase;

/** @covers \App\Factory\JobRequestFactory */
class JobRequestFactoryTest extends KernelTestCase implements ServiceContainerTestCase
{
    use SymfonyTestContainer;
    use JobRequestContext;

    /**
     * @var JobRequestFactoryInterface
     * @inject app.factory.job_request
     */
    private $jobRequestFactory = null;

    public function testCreateNewJobRequest()
    {
        $jobRequestFactory = $this->jobRequestFactory;
        $jobRequestParseErrors = [];
        $jobRequestDTO = $jobRequestFactory(json_encode(self::$validPayload), $jobRequestParseErrors);

        $this->assertInstanceOf(JobRequestDTO::class, $jobRequestDTO);
        $this->assertNotNull($jobRequestDTO->getTitle());
        $this->assertEquals(self::$validPayload["title"], $jobRequestDTO->getTitle());
    }

    public function testCreateNewJobRequestNotJsonPayload()
    {
        $jobRequestFactory = $this->jobRequestFactory;
        $jobRequestParseErrors = [];
        $jobRequestDTO = $jobRequestFactory("wrong payload", $jobRequestParseErrors);

        $this->assertNotInstanceOf(JobRequestDTO::class, $jobRequestDTO);
        $this->assertArrayHasKey("form", $jobRequestParseErrors);
        $this->assertEquals(json_last_error() . "//" . json_last_error_msg(), $jobRequestParseErrors["form"]);
    }

    public function testCreateNewJobRequestMissingField()
    {
        $jobRequestFactory = $this->jobRequestFactory;
        $jobRequestParseErrors = [];
        $modifiedPayload = self::$validPayload;
        unset($modifiedPayload["userId"]);
        $jobRequestDTO = $jobRequestFactory(json_encode($modifiedPayload), $jobRequestParseErrors);

        $this->assertNotInstanceOf(JobRequestDTO::class, $jobRequestDTO);
        $this->assertArrayHasKey("userId", $jobRequestParseErrors);
        $this->assertEquals("Field is missing in the request", $jobRequestParseErrors["userId"]);
    }

    public function testCreateNewJobRequestWrongRequestedDatetime()
    {
        $jobRequestFactory = $this->jobRequestFactory;
        $jobRequestParseErrors = [];
        $modifiedPayload = self::$validPayload;
        $modifiedPayload["requestedDateTime"] = "invalid date";
        $jobRequestDTO = $jobRequestFactory(json_encode($modifiedPayload), $jobRequestParseErrors);

        $this->assertNotInstanceOf(JobRequestDTO::class, $jobRequestDTO);
        $this->assertArrayHasKey("requestedDateTime", $jobRequestParseErrors);
        $this->assertEquals("Field value is not a datetime in valid ISO format", $jobRequestParseErrors["requestedDateTime"]);
    }
}
