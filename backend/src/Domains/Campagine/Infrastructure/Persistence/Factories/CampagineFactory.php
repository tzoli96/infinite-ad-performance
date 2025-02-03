<?php

namespace Domains\Campagine\Infrastructure\Persistence\Factories;

use Domains\Campagine\Infrastructure\Persistence\Models\CampagineEloquent;
use Domains\Campagine\Domain\Enums\CampaignStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class CampagineFactory extends Factory
{
    protected $model = CampagineEloquent::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'status' => $this->faker->randomElement(CampaignStatus::values()),
            'daily_budget' => $this->faker->randomFloat(2, 100, 10000),
            'start_date' => $this->faker->optional()->date(),
            'end_date' => $this->faker->optional()->date(),
        ];
    }
}
