<?php

namespace Domains\CampaignMetrics\Infrastructure\Persistence\Models;

use Domains\CampaignMetrics\Domain\Entities\CampaignMetrics;
use Domains\Campagine\Infrastructure\Persistence\Models\CampagineEloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Domains\CampaignMetrics\Infrastructure\Persistence\Factories\CampaignMetricsFactory;

class CampaignMetricEloquent extends Model
{
    use HasFactory;

    protected $table = 'campaign_metrics';

    protected $fillable = ['campaign_id', 'date', 'impressions', 'clicks', 'spend', 'conversions'];

    protected $casts = [
        'date' => 'date',
        'impressions' => 'integer',
        'clicks' => 'integer',
        'spend' => 'decimal:2',
        'conversions' => 'integer',
    ];

    public function campaign()
    {
        return $this->belongsTo(CampagineEloquent::class, 'campaign_id');
    }

    public function toDomain(): CampaignMetrics
    {
        return new CampaignMetrics(
            id: $this->id,
            campaignId: $this->campaign_id,
            date: new \DateTimeImmutable($this->date),
            impressions: $this->impressions,
            clicks: $this->clicks,
            spend: $this->spend,
            conversions: $this->conversions
        );
    }

    protected static function newFactory(): CampaignMetricsFactory
    {
        return CampaignMetricsFactory::new();
    }
}
