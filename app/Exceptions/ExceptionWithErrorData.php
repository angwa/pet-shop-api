<?php

namespace App\Exceptions;

use Throwable;

class ExceptionWithErrorData extends HttpExceptionWithErrorData
{
    public function __construct(
        string $message, array $error = [], Throwable $previous = null, int $code = 400, array $headers = []
    ) {
        parent::__construct($code, $error, $message, $headers, $previous);
    }
}
