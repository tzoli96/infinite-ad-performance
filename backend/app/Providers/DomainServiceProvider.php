<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Domains\FileScanner\Application\Actions\ScanDomainFilesAction;

class DomainServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        foreach ($this->getDomainServiceProviders() as $providerClass) {
            $this->app->register($providerClass);
        }
    }

    /**
     *
     * @return array<string>
     */
    private function getDomainServiceProviders(): array
    {
        return collect(app(ScanDomainFilesAction::class)(['Infrastructure/Providers'])->files)
            ->map(fn($file) => $this->resolveProviderClass($file))
            ->filter(fn($class) => !is_null($class) && class_exists($class))
            ->values()
            ->all();
    }

    /**
     *
     * @param string $providerPath
     * @return string|null
     */
    private function resolveProviderClass(string $providerPath): ?string
    {
        if (preg_match('#src/Domains/([^/]+)/Infrastructure/Providers/([^/]+)\.php#', $providerPath, $matches)) {
            return "Domains\\{$matches[1]}\\Infrastructure\\Providers\\{$matches[2]}";
        }

        return null;
    }
}

