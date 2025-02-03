<?php

namespace Shared\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function success(mixed $data = null, int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $data
        ], $statusCode);
    }

    public static function error(string $message, int $statusCode = 400): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], $statusCode);
    }
}
