<?php

namespace Domains\Analytics\Application\Services;

use Domains\Analytics\Application\Actions\GetAnalyticsAction;
use Domains\Analytics\Application\Dto\GetAnalyticsDto;

class AnalyticsService
{
    public function __construct(private readonly GetAnalyticsAction $getMetricsAction) {}

    public function getPerformanceData(GetAnalyticsDto $dto): array
    {
        return ($this->getMetricsAction)($dto);
    }
}
