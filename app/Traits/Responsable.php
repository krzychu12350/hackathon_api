<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

/**
 * Trait providing response methods for controllers.
 */
trait Responsable
{
    /**
     * Return a standard success response.
     *
     * @param mixed|null $data
     * @param string|null $message
     * @param int $status
     * @return JsonResponse
     */
    protected function success(mixed $data = null, string $message = null, int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    /**
     * Return a standard error response.
     *
     * @param string $message
     * @param int $status
     * @param array|null $errors
     * @return JsonResponse
     */
    protected function error(string $message, int $status = 400, array $errors = null): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if (!is_null($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $status);
    }

    /**
     * Return a 201 Created response.
     *
     * @param mixed $data
     * @param string $message
     * @return JsonResponse
     */
    protected function created($data = null, string $message = 'Resource created successfully'): JsonResponse
    {
        return $this->success($data, $message, 201);
    }

    /**
     * Return a 204 No Content response.
     *
     * @return JsonResponse
     */
    protected function noContent(): JsonResponse
    {
        return response()->json(null, 204);
    }
}
