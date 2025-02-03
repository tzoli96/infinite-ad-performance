<?php

namespace Domains\Analytics\Application\Controllers;

use Domains\Analytics\Application\Requests\GetAnalyticsRequest;
use Domains\Analytics\Application\Services\AnalyticsService;
use Illuminate\Http\JsonResponse;
use Shared\Helpers\ApiResponse;

class AnalyticsController
{
    public function __construct(private readonly AnalyticsService $service) {}

    public function getPerformanceMetrics(GetAnalyticsRequest $request): JsonResponse
    {
        $metrics = $this->service->getPerformanceData($request->toDto());
        return ApiResponse::success($metrics, 201);
    }
}
