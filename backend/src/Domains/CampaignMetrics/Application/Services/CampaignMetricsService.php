<?php

namespace Domains\CampaignMetrics\Application\Services;

use Domains\CampaignMetrics\Application\Actions\CreateCampaignMetricsAction;
use Domains\CampaignMetrics\Application\Actions\GetCampaignMetricsAction;
use Domains\CampaignMetrics\Application\Dto\CreateCampaignMetricsDto;
use Domains\CampaignMetrics\Application\Dto\GetCampaignMetricsDto;

class CampaignMetricsService
{
    public function __construct(
        private readonly CreateCampaignMetricsAction $createAction,
        private readonly GetCampaignMetricsAction $getMetricsAction
    ) {}

    public function store(CreateCampaignMetricsDto $dto)
    {
        return ($this->createAction)($dto);
    }

    public function getMetrics(GetCampaignMetricsDto $dto)
    {
        return ($this->getMetricsAction)($dto);
    }
}
