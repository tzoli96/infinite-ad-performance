<?php

namespace Domains\Campagine\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Domains\Campagine\Domain\Repositories\CampagineRepositoryInterface;
use Domains\Campagine\Infrastructure\Persistence\Repositories\CampagineRepository;

class CampagineServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CampagineRepositoryInterface::class, CampagineRepository::class);
    }
}
