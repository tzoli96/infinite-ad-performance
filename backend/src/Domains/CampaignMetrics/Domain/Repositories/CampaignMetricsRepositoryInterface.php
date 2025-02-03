<?php

namespace Domains\CampaignMetrics\Domain\Repositories;


interface CampaignMetricsRepositoryInterface
{
    public function getMetricsByCampaign(int $campaignId, ?\DateTimeImmutable $startDate, ?\DateTimeImmutable $endDate): array;
}
