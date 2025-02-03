<?php

namespace Domains\CampaignMetrics\Infrastructure\Persistence\Factories;

use Domains\CampaignMetrics\Infrastructure\Persistence\Models\CampaignMetricEloquent;
use Illuminate\Database\Eloquent\Factories\Factory;

class CampaignMetricsFactory extends Factory
{
    protected $model = CampaignMetricEloquent::class;

    public function definition(): array
    {
        return [
            'campaign_id' => 1,
            'date' => $this->faker->date(),
            'impressions' => $this->faker->numberBetween(1000, 10000),
            'clicks' => $this->faker->numberBetween(100, 1000),
            'spend' => $this->faker->randomFloat(2, 10, 500),
            'conversions' => $this->faker->numberBetween(1, 100),
        ];
    }
}
