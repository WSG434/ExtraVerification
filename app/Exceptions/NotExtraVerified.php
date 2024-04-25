<?php

namespace App\Exceptions;

use Exception;

class NotExtraVerified extends Exception
{
    public function __construct(string $message = null, int $code = 401, ?Throwable $previous = null)
    {
        parent::__construct($message ?? 'Not ExtraVerified', $code, $previous);
    }
}
