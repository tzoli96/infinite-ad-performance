<?php

namespace Domains\CampaignMetrics\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Domains\CampaignMetrics\Domain\Repositories\CampaignMetricsRepositoryInterface;
use Domains\CampaignMetrics\Infrastructure\Persistence\Repositories\CampaignMetricsRepository;

class CampaignMetricsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CampaignMetricsRepositoryInterface::class, CampaignMetricsRepository::class);
    }
}
