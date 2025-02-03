<?php

namespace Domains\Analytics\Infrastructure\Providers;

use Domains\Analytics\Domain\Repositories\AnalyticsRepositoryInterface;
use Domains\Analytics\Infrastructure\Persistence\Repositories\AnalyticsRepository;
use Illuminate\Support\ServiceProvider;

class AnalyticsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AnalyticsRepositoryInterface::class, AnalyticsRepository::class);
    }
}
