<?php

namespace App\Core;

use Exception;
use Throwable;

class ServiceException extends Exception
{
    public function __construct(string $message, int $code = 400, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
