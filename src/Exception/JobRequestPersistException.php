<?php

namespace App\Exception;

use Doctrine\ORM\ORMException;

class JobRequestPersistException extends \Exception
{
    /**
     * @param ORMException|\Exception $ex
     */
    public function __construct(ORMException $ex)
    {
        $this->message = $ex->message;
    }
}
