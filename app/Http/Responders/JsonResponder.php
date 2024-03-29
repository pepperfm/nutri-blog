<?php

declare(strict_types=1);

namespace App\Http\Responders;

use Illuminate\Support\Collection;
use Illuminate\Http\JsonResponse;
use App\Contracts\ResponseContract;

class JsonResponder implements ResponseContract
{
    /** @var array<string, string> $headers */
    private array $headers = ['Content-Type' => 'application/json; charset=UTF-8', 'charset' => 'utf-8'];

    public static function make(): static
    {
        return new static();
    }

    /**
     * @inheritdoc
     */
    public function response(
        array|Collection $data,
        array $meta = [],
        string $message = 'Success',
        int $httpStatusCode = JsonResponse::HTTP_OK
    ): JsonResponse {
        return response()->json([
            'entities' => $data,
            'meta' => $meta,
        ], $httpStatusCode, $this->headers, JSON_UNESCAPED_UNICODE);
    }

    /**
     * @inheritdoc
     */
    public function error(
        string $message = 'Error',
        int $httpStatusCode = JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
        mixed $errors = null,
        mixed $data = null
    ): JsonResponse {
        return response()->json($data, $httpStatusCode, $this->headers, JSON_UNESCAPED_UNICODE);
    }

    /**
     * @param array $data
     * @param string $message
     *
     * @return JsonResponse
     */
    public function stored(
        array $data,
        string $message = '',
    ): JsonResponse {
        return $this->response($data, $message, JsonResponse::HTTP_CREATED);
    }

    /**
     * @param array $data
     * @param string $message
     *
     * @return JsonResponse
     */
    public function deleted(
        array $data,
        string $message = '',
    ): JsonResponse {
        return $this->response($data, $message, JsonResponse::HTTP_NO_CONTENT);
    }
}
