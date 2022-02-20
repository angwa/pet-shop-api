<?php

use App\Exceptions\HttpExceptionWithErrorData;
use App\Transformers\JsonResponse;
use Illuminate\Http\JsonResponse as LaravelJsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

if (!function_exists('JSON')) {
    /**
     * Creates a JSON response using the translations
     *
     * Usages
     *
     * return JSON(200, 'A message');
     * return JSON(200, 'A message', []);
     * return JSON(200, 'A message', ['message' => 'Response Body']);
     * return JSON(200, 'Transaction successful');
     * return JSON(200, 'transaction_being_processed:amount=200');
     * return JSON(200, 'transaction_being_processed', ['message_attributes' => ['amount' => 200]]);
     *
     * $a = \Validator::make([], ['a' => 'required']);
     * return JSON(422, 'validation_failed', $a->errors());
     * return JSON(422, 'validation_failed', $a->errors()->all());
     *
     * @param int $status_code
     * @param string $message
     * @param \Illuminate\Contracts\Support\Arrayable|array|null $data
     * @param array $headers
     *
     * @return JsonResponse
     */
    function JSON(int $status_code, string $message, $data = null, array $headers = []): LaravelJsonResponse
    {
        return JsonResponse::create($status_code, $message, $data, $headers);
    }
}

if (!function_exists('abort_with_exception')) {
    /**
     * Aborts the request with an exception
     *
     * @param \Throwable $exception
     * @param int $status_code
     * @param string $message
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    function abort_with_exception(
        Throwable $exception,
        int $status_code = 500,
        string $message = 'server_error'
    ) {
        if ($exception instanceof HttpExceptionInterface) {
            $status_code = $exception->getStatusCode();
            $message = $exception->getMessage();
            $exception = $exception->getPrevious();
        }

        throw new HttpException($status_code, $message, $exception);
    }
}

if (!function_exists('abort_with_error')) {
    /**
     * Throw an HttpExceptionWithErrorData with the given error data.
     *
     * @param int $code
     * @param string $message
     * @param array $error
     * @param \Throwable $exception
     * @param array $headers
     *
     * @throws \App\Exceptions\HttpExceptionWithErrorData
     */
    function abort_with_error(int $code, string $message, array $error, Throwable $exception = null, array $headers = [])
    {
        throw new HttpExceptionWithErrorData($code, $error, $message, $headers, $exception);
    }
}


if (!function_exists('JSONDATA')) {
    /**
     * Returns json data
     *
     * @param int $status_code
     * @param array $data
     *
     * @return LaravelJsonResponse
     */
    function JSONDATA(int $status_code, $data = null, array $headers = [])
    {
        return new LaravelJsonResponse($data, $status_code, $headers);
    }
}

const CODE_SUCCESS = 200;
const CODE_CREATED = 201;
const CODE_ACCEPTED = 202;
const CODE_REDIRECT = 302;
const CODE_BAD_REQUEST = 400;
const CODE_UNAUTHORIZED = 401;
const CODE_PAYMENT_NEEDED = 402;
const CODE_AUTHORIZATION_NEEDED = 419;
const CODE_FORBIDDEN = 403;
const CODE_NOT_FOUND = 404;
const CODE_METHOD_NOT_ALLOWED = 405;
const CODE_VALIDATION_ERROR = 422;
const CODE_SERVER_ERROR = 500;
const CODE_BAD_GATEWAY = 502;
const CODE_SERVICE_UNAVAILABLE = 503;

const PAYMENT_CODE_SUCCESS = 00;
const PAYMENT_CODE_FAILED = 06;
const PAYMENT_CODE_ERROR = 499;
