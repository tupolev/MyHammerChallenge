<?php

namespace App\Tests\Model;

use App\DTO\JobRequestDTO;
use App\Model\JobRequestModelInterface;
use App\Tests\App\Context\JobRequestContext;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use TypeError;
use Zalas\Injector\PHPUnit\Symfony\TestCase\SymfonyTestContainer;
use Zalas\Injector\PHPUnit\TestCase\ServiceContainerTestCase;

/** @covers \App\Model\JobRequestModel */
class JobRequestModelTest extends KernelTestCase implements ServiceContainerTestCase
{
    use SymfonyTestContainer;
    use JobRequestContext;
    /**
     * @var JobRequestModelInterface
     * @inject app.model.job_request
     */
    private $jobRequestModel = null;

    /**
     * @expectedException TypeError
     */
    public function testNullPayloadCreateNewJobRequest()
    {
        /* Test wrong payload */
        $jobRequestDTO = new JobRequestDTO();
        $jobRequestCreationErrors = [];
        $this->jobRequestModel->createNewJobRequest($jobRequestDTO, $jobRequestCreationErrors);
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
        $this->jobRequestModel->createNewJobRequest($jobRequestDTO, $jobRequestCreationErrors);
        $this->assertTrue(true);
    }

    /**
     * @expectedException \App\Exception\JobRequestPersistException
     */
    public function testInvalidPayloadCreateNewJobRequest()
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
        $this->jobRequestModel->createNewJobRequest($jobRequestDTO, $jobRequestCreationErrors);
    }
}
