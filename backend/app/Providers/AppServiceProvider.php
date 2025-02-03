<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Domains\FileScanner\Application\Actions\ScanDomainFilesAction;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $action = app(ScanDomainFilesAction::class);
        $result = $action(['Infrastructure/Persistence/Migrations']);

        foreach ($result->files as $migrationPath) {
            $this->loadMigrationsFrom($migrationPath);
        }
    }
}

