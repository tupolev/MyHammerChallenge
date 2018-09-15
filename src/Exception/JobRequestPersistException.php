<?php

namespace App\Exception;

use Doctrine\DBAL\DBALException;
use Doctrine\ORM\ORMException;

class JobRequestPersistException extends \Exception
{
    /**
     * @param ORMException|DBALException|\Exception $ex
     */
    public function __construct(\Exception $ex)
    {
        $this->message = $ex->message;
    }
}
