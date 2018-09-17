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
        $jobRequestDTO = $this->jobRequestFactory->buildJobRequestDTO(json_encode(self::$validPayload));

        $this->assertInstanceOf(JobRequestDTO::class, $jobRequestDTO);
        $this->assertNotNull($jobRequestDTO->getTitle());
        $this->assertEquals(self::$validPayload["title"], $jobRequestDTO->getTitle());
    }
}
