<?php

namespace Domains\Campagine\Application\Controllers;

use Domains\Campagine\Application\Requests\CreateCampagineRequest;
use Domains\Campagine\Application\Requests\UpdateCampagineRequest;
use Domains\Campagine\Application\Services\CampagineService;
use Shared\Helpers\ApiResponse;
use Illuminate\Http\JsonResponse;

class CampagineController
{
    public function __construct(private readonly CampagineService $campagineService) {}

    public function index(): JsonResponse
    {
        return ApiResponse::success($this->campagineService->getAllCampaigns());
    }

    public function store(CreateCampagineRequest $request): JsonResponse
    {
        $campaign = $this->campagineService->createCampaign($request->toDto());

        return ApiResponse::success($campaign, 201);
    }

    public function update(int $id, UpdateCampagineRequest $request): JsonResponse
    {
        try {
            $campaign = $this->campagineService->updateCampaign($id, $request->toDto());
            return ApiResponse::success($campaign);

        } catch (\Exception $exception) {
            return ApiResponse::error($exception->getMessage());
        }

    }

    public function destroy(int $id): JsonResponse
    {
        $this->campagineService->deleteCampaign($id);
        return ApiResponse::success(['message' => 'Campaign deleted']);
    }
}
