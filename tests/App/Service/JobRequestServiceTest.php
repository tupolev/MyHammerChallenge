<?php

namespace App\Tests\Service;

use App\DTO\JobRequestDTO;
use App\Service\JobRequestServiceInterface;
use App\Tests\App\Context\JobRequestContext;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use TypeError;
use Zalas\Injector\PHPUnit\Symfony\TestCase\SymfonyTestContainer;
use Zalas\Injector\PHPUnit\TestCase\ServiceContainerTestCase;

/** @covers \App\Service\JobRequestService */
class JobRequestServiceTest extends KernelTestCase implements ServiceContainerTestCase
{
    use SymfonyTestContainer;
    use JobRequestContext;

    /**
     * @var JobRequestServiceInterface
     * @inject app.service.job_request
     */
    private $jobRequestService = null;

    /**
     * @expectedException TypeError
     */
    public function testNullPayloadCreateNewJobRequest()
    {
        /* Test wrong payload */
        $jobRequestDTO = new JobRequestDTO();
        $jobRequestCreationErrors = [];
        $this->jobRequestService->createNewJobRequest($jobRequestDTO, $jobRequestCreationErrors);
        $this->expectException(TypeError::class);
    }

    public function testValidPayloadCreateNewJobRequest()
    {
        $jobRequestCreationErrors = [];

        /* test valid payload  */
        $jobRequestDTO = new JobRequestDTO();
        $jobRequestDTO->setTitle(self::$validPayload["title"]);
        $jobRequestDTO->setDescription(self::$validPayload["description"]);
        $jobRequestDTO->setRequestedDateTime(
            \DateTime::createFromFormat(\DateTime::ISO8601, self::$validPayload["requestedDateTime"])
        );
        $jobRequestDTO->setUserId(self::$validPayload["userId"]);
        $jobRequestDTO->setLocationId(self::$validPayload["locationId"]);
        $jobRequestDTO->setCategoryId(self::$validPayload["categoryId"]);
        $this->jobRequestService->createNewJobRequest($jobRequestDTO, $jobRequestCreationErrors);
        $this->assertTrue(true);
    }

    /**
     * @expectedException \App\Exception\JobRequestPersistException
     */
    public function testInvalidCreateNewJobRequest()
    {
        $jobRequestCreationErrors = [];

        /* test invalid payload  */
        $jobRequestDTO = new JobRequestDTO();
        $jobRequestDTO->setTitle(self::$invalidPayload["title"]);
        $jobRequestDTO->setDescription(self::$invalidPayload["description"]);
        $jobRequestDTO->setRequestedDateTime(
            \DateTime::createFromFormat(\DateTime::ISO8601, self::$invalidPayload["requestedDateTime"])
        );
        $jobRequestDTO->setUserId(self::$invalidPayload["userId"]);
        $jobRequestDTO->setLocationId(self::$invalidPayload["locationId"]);
        $jobRequestDTO->setCategoryId(self::$invalidPayload["categoryId"]);
        $this->jobRequestService->createNewJobRequest($jobRequestDTO, $jobRequestCreationErrors);
    }
}
