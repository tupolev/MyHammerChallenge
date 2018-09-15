<?php

namespace App\Tests\Controller;


use App\Controller\JobRequestController;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Input\StringInput;

class JobRequestControllerTest extends WebTestCase
{
    protected static $application;

    private $payload = [
        "categoryId" => "804040",
        "userId" =>  "524",
        "locationId" =>  "1",
        "title" =>  "Umzug von Pankow nach Charlottenburg",
        "description" =>  "Ich brauche Hilfe. Ich muss nach Charlottenburg umziehen aber habe kein Auto dafür.",
        "requestedDateTime" =>  "2018-10-11T10:10:00Z",
    ];

    protected function setUp()
    {
        self::runCommand('doctrine:database:create');
        self::runCommand('doctrine:schema:update --force');
        self::runCommand('doctrine:fixtures:load --purge-with-truncate --no-interaction');
    }

    public function testCreate()
    {
        $client = static::createClient();
        $client->request('POST', '/job_request', [], [], [], json_encode($this->payload));

        $this->assertEquals(JobRequestController::HTTP_STATUS_CREATED, $client->getResponse()->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            $client->getResponse()->getContent(),
            '{"status":"success","message":"Success","fields":[]}'
        );
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
