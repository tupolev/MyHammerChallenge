<?php

namespace App\Tests\Controller;


use App\Controller\JobRequestController;
use App\Tests\App\Context\JobRequestContext;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Input\StringInput;
use Zalas\Injector\PHPUnit\Symfony\TestCase\SymfonyTestContainer;
use Zalas\Injector\PHPUnit\TestCase\ServiceContainerTestCase;

/** @covers \App\Controller\JobRequestController */
class JobRequestControllerTest extends WebTestCase implements ServiceContainerTestCase
{
    use SymfonyTestContainer;
    use JobRequestContext;

    protected static $application;

    protected function setUp()
    {
        self::runCommand('doctrine:database:create');
        self::runCommand('doctrine:schema:update --force');
        self::runCommand('doctrine:fixtures:load --purge-with-truncate --no-interaction');
        parent::setUp();
    }

    public function testConstruct()
    {
        $container = $this->createContainer();
        $jobRequestService = $container->get("app.service.job_request");
        $jobRequestFactory = $container->get("app.factory.job_request");
        $logger = $container->get("logger");

        $this->assertInstanceOf(JobRequestController::class, new JobRequestController($jobRequestService, $jobRequestFactory, $logger));
    }

    /** @covers \App\Controller\JobRequestController::postAction */
    public function testCreate()
    {
        $client = static::createClient();

        //Create with valid payload
        $client->request('POST', '/api/job_request', [], [], [], json_encode(self::$validPayload));
        $this->assertEquals(JobRequestController::HTTP_STATUS_CREATED, $client->getResponse()->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            $client->getResponse()->getContent(),
            '{"status":"success","message":"Success","fields":[]}'
        );

        //create with wrong body
        $client->request('POST', '/api/job_request', [], [], [], "");
        $this->assertEquals(JobRequestController::HTTP_STATUS_BAD_REQUEST, $client->getResponse()->getStatusCode());

        //create with invalid payload
        $client->request('POST', '/api/job_request', [], [], [], json_encode(self::$invalidPayload));
        $this->assertEquals(JobRequestController::HTTP_STATUS_BAD_REQUEST, $client->getResponse()->getStatusCode());

        //create with invalid locationId
        $modifiedPayload = self::$validPayload;
        $modifiedPayload["locationId"] = -10;
        $client->request('POST', '/api/job_request', [], [], [], json_encode($modifiedPayload));
        $this->assertEquals(JobRequestController::HTTP_STATUS_CONFLICT, $client->getResponse()->getStatusCode());
    }

    /**
     * @param $command
     * @return int
     *
     * @throws \Exception
     */
    protected static function runCommand($command)
    {
        $command = sprintf('%s --quiet', $command);

        return self::getApplication()->run(new StringInput($command));
    }

    /**
     * @return Application
     */
    protected static function getApplication()
    {
        if (null === self::$application) {
            $client = static::createClient();

            self::$application = new Application($client->getKernel());
            self::$application->setAutoExit(false);
        }

        return self::$application;
    }
}
