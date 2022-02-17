<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class HttpExceptionWithErrorData extends HttpException
{
    /**
     * The error array
     *
     * @var array
     */
    protected $error = [];

    /**
     * @param int $code The HTTP status code
     * @param array $error The error data array
     * @param string $message The internal exception message
     * @param array $header The HTTP response headers to attach
     * @param \Throwable|null $previous The previous exception
     *
     * @return void
     */
    public function __construct(int $code, array $error, string $message = null, array $headers = [], \Throwable $previous = null)
    {
        $this->error = $error;

        parent::__construct($code, $message, $previous, $headers);
    }

    /**
     * Gets the error data
     *
     * @return array
     */
    public function getErrorDetails()
    {
        return $this->error;
    }
}
