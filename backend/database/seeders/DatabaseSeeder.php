<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Domains\FileScanner\Application\Actions\ScanDomainFilesAction;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $action = app(ScanDomainFilesAction::class);
        $result = $action(['Infrastructure/Persistence/Seeders']);

        foreach ($result->files as $seederPath) {
            $seederClass = 'Domains\\' . basename(dirname($seederPath, 4)) . '\\Infrastructure\\Persistence\\Seeders\\' . pathinfo($seederPath, PATHINFO_FILENAME);

            if (class_exists($seederClass)) {
                $this->call($seederClass);
            }
        }
    }
}
