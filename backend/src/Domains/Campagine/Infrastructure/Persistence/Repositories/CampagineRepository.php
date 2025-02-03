<?php

namespace Domains\Campagine\Infrastructure\Persistence\Repositories;

use Domains\Campagine\Domain\Entities\Campagine;
use Domains\Campagine\Infrastructure\Persistence\Models\CampagineEloquent;
use Illuminate\Database\Eloquent\Model;
use Shared\Infrastructure\Persistence\AbstractRepository;
use Domains\Campagine\Domain\Repositories\CampagineRepositoryInterface;

class CampagineRepository extends AbstractRepository implements CampagineRepositoryInterface
{
    public function __construct(CampagineEloquent $model)
    {
        parent::__construct($model);
    }

    protected function fromDomain(object $domainEntity): array
    {
        return [
            'name' => $domainEntity->name,
            'status' => $domainEntity->status,
            'daily_budget' => $domainEntity->dailyBudget,
            'start_date' => $domainEntity->startDate?->format('Y-m-d'),
            'end_date' => $domainEntity->endDate?->format('Y-m-d'),
        ];
    }

    protected function toDomain(CampagineEloquent|Model $model): Campagine
    {
        return new Campagine(
            id: $model->id,
            name: $model->name,
            status: $model->status,
            dailyBudget: $model->daily_budget,
            startDate: $model->start_date ? new \DateTimeImmutable($model->start_date) : null,
            endDate: $model->end_date ? new \DateTimeImmutable($model->end_date) : null
        );
    }
}
