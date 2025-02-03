<?php

namespace Shared\Infrastructure\Persistence;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

abstract class AbstractRepository
{
    protected Builder $query;

    public function __construct(protected Model $model)
    {
        $this->query = $this->model->newQuery();
    }

    public function findById(int $id): ?object
    {
        $entity = $this->query->find($id);
        return $entity ? $this->toDomain($entity) : null;
    }

    public function getAll(): Collection
    {
        return $this->query->get()->map(fn ($entity) => $this->toDomain($entity));
    }

    public function save(object $domainEntity): object
    {
        $data = $this->fromDomain($domainEntity);
        $model = $this->query->updateOrCreate(['id' => $domainEntity->id ?? null], $data);
        return $this->toDomain($model);
    }

    public function delete(int $id): void
    {
        $this->query->where('id', $id)->delete();
    }

    abstract protected function fromDomain(object $domainEntity): array;

    abstract protected function toDomain(Model $model): object;
}
