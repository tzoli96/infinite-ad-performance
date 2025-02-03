<?php

namespace Domains\Campagine\Infrastructure\Persistence\Seeders;

use Illuminate\Database\Seeder;
use Domains\Campagine\Infrastructure\Persistence\Models\CampagineEloquent;

class CampagineSeeder extends Seeder
{
    public function run(): void
    {
        CampagineEloquent::query()->delete();

        CampagineEloquent::factory()->count(10)->create();
    }
}
