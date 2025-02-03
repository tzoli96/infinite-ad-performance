<?php

namespace Domains\Campagine\Infrastructure\Persistence\Models;

use Domains\CampaignMetrics\Infrastructure\Persistence\Models\CampaignMetricEloquent;
use Domains\Campagine\Domain\Entities\Campagine;
use Domains\Campagine\Domain\Enums\CampaignStatus;
use Domains\Campagine\Infrastructure\Persistence\Factories\CampagineFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampagineEloquent extends Model
{
    use HasFactory;

    protected $table = 'campaigns';

    protected $fillable = ['name', 'status', 'daily_budget', 'start_date', 'end_date'];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'daily_budget' => 'decimal:2',
        'status' => CampaignStatus::class,
    ];

    public function metrics()
    {
        return $this->hasMany(CampaignMetricEloquent::class, 'campaign_id');
    }

    public function toDomain(): Campagine
    {
        return new Campagine(
            id: $this->id,
            name: $this->name,
            status: $this->status,
            dailyBudget: $this->daily_budget,
            startDate: $this->start_date ? new \DateTimeImmutable($this->start_date) : null,
            endDate: $this->end_date ? new \DateTimeImmutable($this->end_date) : null,
            createdAt: new \DateTimeImmutable($this->created_at),
            updatedAt: new \DateTimeImmutable($this->updated_at)
        );
    }

    protected static function newFactory(): CampagineFactory
    {
        return CampagineFactory::new();
    }
}
