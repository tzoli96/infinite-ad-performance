<?php

namespace Domains\CampaignMetrics\Infrastructure\Persistence\Repositories;

use Domains\CampaignMetrics\Domain\Repositories\CampaignMetricsRepositoryInterface;
use Domains\CampaignMetrics\Domain\Entities\CampaignMetrics;
use Domains\CampaignMetrics\Infrastructure\Persistence\Models\CampaignMetricEloquent;
use Illuminate\Database\Eloquent\Model;
use Shared\Infrastructure\Persistence\AbstractRepository;

class CampaignMetricsRepository extends AbstractRepository implements CampaignMetricsRepositoryInterface
{
    public function __construct(CampaignMetricEloquent $model)
    {
        parent::__construct($model);
    }

    protected function fromDomain(object $domainEntity): array
    {
        return [
            'campaign_id' => $domainEntity->campaignId,
            'date' => $domainEntity->date->format('Y-m-d'),
            'impressions' => $domainEntity->impressions,
            'clicks' => $domainEntity->clicks,
            'spend' => $domainEntity->spend,
            'conversions' => $domainEntity->conversions,
        ];
    }

    protected function toDomain(CampaignMetricEloquent|Model $model): CampaignMetrics
    {
        return new CampaignMetrics(
            id: $model->id,
            campaignId: $model->campaign_id,
            date: new \DateTimeImmutable($model->date),
            impressions: $model->impressions,
            clicks: $model->clicks,
            spend: $model->spend,
            conversions: $model->conversions
        );
    }

    public function getMetricsByCampaign(int $campaignId, ?\DateTimeImmutable $startDate, ?\DateTimeImmutable $endDate): array
    {
        $query = CampaignMetricEloquent::where('campaign_id', $campaignId);

        if ($startDate) {
            $query->where('date', '>=', $startDate->format('Y-m-d'));
        }

        if ($endDate) {
            $query->where('date', '<=', $endDate->format('Y-m-d'));
        }

        return $query->get()->map(fn ($metric) => $metric->toDomain())->toArray();
    }
}
