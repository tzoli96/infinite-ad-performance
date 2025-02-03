<?php

namespace Domains\CampaignMetrics\Infrastructure\Persistence\Seeders;

use Illuminate\Database\Seeder;
use Domains\CampaignMetrics\Infrastructure\Persistence\Models\CampaignMetricEloquent;
use Domains\Campagine\Infrastructure\Persistence\Models\CampagineEloquent;

class CampaignMetricsSeeder extends Seeder
{
    public function run(): void
    {
        CampagineEloquent::all()->each(function (CampagineEloquent $campaign) {
            CampaignMetricEloquent::factory()
                ->count(10)
                ->create(['campaign_id' => $campaign->id]);
        });
    }
}
