<?php

declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

interface ResponseContract
{
    /**
     * Success response method
     *
     * @param array|Collection $data
     * @param array $meta,
     * @param string $message
     * @param int $httpStatusCode
     *
     * @return JsonResponse
     */
    public function response(
        array|Collection $data,
        array $meta = [],
        string $message = 'Success',
        int $httpStatusCode = JsonResponse::HTTP_OK
    ): JsonResponse;

    /**
     * Error response method
     *
     * @param string $message
     * @param int $httpStatusCode
     * @param ?mixed $errors
     * @param ?mixed $data
     *
     * @return JsonResponse
     */
    public function error(
        string $message = 'Error',
        int $httpStatusCode = JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
        mixed $errors = null,
        mixed $data = null
    ): JsonResponse;
}
