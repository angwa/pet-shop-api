<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Routing\Exceptions\InvalidSignatureException;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Exception\SuspiciousOperationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        SuspiciousOperationException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        if (! app()->environment('local') && app()->bound('sentry') && $this->shouldReport($exception)) {
            app('sentry')->captureException($exception);
        }

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     *
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        $exception = $this->prepareException($exception);

        if ($exception instanceof ValidationException) {
            return JSON($exception->status, 'Validation Failed', $exception->errors());
        }

        if ($exception instanceof HttpException) {
            $status_code = $exception->getStatusCode();
            $error_message = $exception->getMessage() ?: Response::$statusTexts[$status_code];

            $error_data = ($exception instanceof HttpExceptionWithErrorData) ? $exception->getErrorDetails() : [];

            return JSON($status_code, $error_message, $error_data);
        }

        $is_local = app()->environment('local');

        if ($exception instanceof Throwable && ! $is_local) {
            $error_data = (config('app.debug', false)) ? [
                'message' => sprintf('%s in the file: %s on line %u', $exception->getMessage(), $exception->getFile(), $exception->getLine()),
                'code' => $exception->getCode(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'traces' => $exception->getTrace(),
            ] : [];

            return JSON(CODE_SERVER_ERROR, 'server_error', $error_data);
        }

        return parent::render($request, $exception);
    }

    /**
     * {inheritdoc}
     */
    protected function prepareException(Throwable $e)
    {
        if ($e instanceof ModelNotFoundException) {
            return new NotFoundHttpException('Resource not found');
        } elseif ($e instanceof TokenBlacklistedException) {
            return new HttpException(401, 'error_code.session_blacklisted');
        } elseif ($e instanceof InvalidSignatureException) {
            return new HttpException(403, 'This url is no longer valid or has expired!');
        } elseif ($e instanceof AuthenticationException) {
            return new HttpException(401, $e->getMessage(), $e);
        } elseif ($e instanceof UnauthorizedException) {
            return new HttpException(403, $e->getMessage(), $e);
        } elseif ($e instanceof SuspiciousOperationException) {
            return new NotFoundHttpException('Resource not found', $e);
        }

        return parent::prepareException($e);
    }

    protected function shouldntReport(Throwable $e)
    {
        return parent::shouldntReport($e) && $this->shouldntReportPrevious($e);
    }

    protected function shouldntReportPrevious(Throwable $e)
    {
        $previousException = $e->getPrevious();

        if (is_null($previousException)) {
            return true;
        }

        $dontReportPrevious = [
            HttpExceptionInterface::class,
            JWTException::class,
        ];

        return collect($dontReportPrevious)->filter(function ($type) use ($previousException) {
            return $previousException instanceof $type;
        })->isNotEmpty();
    }
}
