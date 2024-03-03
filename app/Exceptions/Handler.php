<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param \Throwable $exception
     *
     * @throws \Exception
     * @return void
     *
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $exception
     *
     * @throws \Throwable
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request, Throwable $exception): JsonResponse
    {
        $parentRender = parent::render($request, $exception);

        if ($parentRender instanceof JsonResponse) {
            return $parentRender;
        }

        return new JsonResponse([
            'errors' => [
                [
                    'status' => $parentRender->getStatusCode(),
                    'title' => $exception instanceof HttpException
                        ? $exception->getMessage()
                        : (static function () use ($exception) {
                            app('log')->error($exception->getMessage());

                            if (app()->environment('local')) {
                                return $exception->getMessage();
                            }
                            return 'Server Error';
                        })(),
                ],
            ],
            'status' => $parentRender->status(),
        ], $parentRender->status());
    }
}
