<?php

namespace Domains\CampaignMetrics\Application\Controllers;

use Domains\CampaignMetrics\Application\Requests\CreateCampaignMetricsRequest;
use Domains\CampaignMetrics\Application\Requests\GetCampaignMetricsRequest;
use Domains\CampaignMetrics\Application\Services\CampaignMetricsService;
use Shared\Helpers\ApiResponse;
use Illuminate\Http\JsonResponse;

class CampaignMetricsController
{
    public function __construct(private readonly CampaignMetricsService $service) {}

    public function store(CreateCampaignMetricsRequest $request): JsonResponse
    {
        return ApiResponse::success($this->service->store($request->toDto()), 201);
    }

    public function index(GetCampaignMetricsRequest $request): JsonResponse
    {
        return ApiResponse::success($this->service->getMetrics($request->toDto()));
    }
}
