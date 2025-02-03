<?php

namespace Domains\Analytics\Infrastructure\Persistence\Repositories;

use Domains\Analytics\Domain\Repositories\AnalyticsRepositoryInterface;
use Domains\CampaignMetrics\Infrastructure\Persistence\Models\CampaignMetricEloquent;

class AnalyticsRepository implements AnalyticsRepositoryInterface
{
    public function getPerformanceMetrics(?\DateTimeImmutable $startDate, ?\DateTimeImmutable $endDate): array
    {
        $query = CampaignMetricEloquent::query();

        if ($startDate) {
            $query->where('date', '>=', $startDate->format('Y-m-d'));
        }

        if ($endDate) {
            $query->where('date', '<=', $endDate->format('Y-m-d'));
        }

        $metrics = $query->selectRaw("
            SUM(spend) as total_spend,
            SUM(conversions) as total_conversions,
            CASE WHEN SUM(impressions) > 0 THEN SUM(clicks) / SUM(impressions) ELSE 0 END as ctr,
            CASE WHEN SUM(clicks) > 0 THEN SUM(conversions) / SUM(clicks) ELSE 0 END as conversion_rate
        ")->first();


        return [
            'total_spend' => $metrics->total_spend ?? 0,
            'total_conversions' => $metrics->total_conversions ?? 0,
            'ctr' => round($metrics->ctr * 100, 2) . '%',
            'conversion_rate' => round($metrics->conversion_rate * 100, 2) . '%',
        ];
    }
}
