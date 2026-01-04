<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;

/**
 * Trait ApiResponse
 *
 * Provides standardized JSON responses for API controllers.
 */
trait ApiResponse
{
    protected function success($data = null, string $message = null, int $code = 200): JsonResponse
    {
        $payload = [
            'status' => 'success',
        ];

        if ($message !== null) {
            $payload['message'] = $message;
        }

        $payload['data'] = $data;

        return response()->json($payload, $code);
    }

    protected function error(string $message, int $code = 500, $errors = null): JsonResponse
    {
        $payload = [
            'status' => 'error',
            'message' => $message,
        ];

        if ($errors !== null) {
            $payload['errors'] = $errors;
        }

        return response()->json($payload, $code);
    }

    protected function validation($errors, string $message = 'Validation failed', int $code = 422): JsonResponse
    {
        return $this->error($message, $code, $errors);
    }

    protected function paginated($paginator, $transformer = null, string $message = null, int $code = 200): JsonResponse
    {
        $items = $paginator;

        if ($paginator instanceof Paginator || $paginator instanceof LengthAwarePaginator) {
            $items = $paginator->items();
        }

        if ($transformer && is_callable($transformer)) {
            $items = array_map($transformer, $items);
        }

        $meta = [];

        if ($paginator instanceof Paginator) {
            $meta = [
                'current_page' => $paginator->currentPage(),
                'from' => method_exists($paginator, 'firstItem') ? $paginator->firstItem() : null,
                'last_page' => method_exists($paginator, 'lastPage') ? $paginator->lastPage() : null,
                'per_page' => $paginator->perPage(),
                'to' => method_exists($paginator, 'lastItem') ? $paginator->lastItem() : null,
                'total' => method_exists($paginator, 'total') ? $paginator->total() : null,
            ];
        }

        $payload = [
            'status' => 'success',
            'data' => $items,
            'meta' => $meta,
        ];

        if ($message !== null) {
            $payload['message'] = $message;
        }

        return response()->json($payload, $code);
    }

    protected function noContent(int $code = 204): JsonResponse
    {
        return response()->json(null, $code);
    }
}
