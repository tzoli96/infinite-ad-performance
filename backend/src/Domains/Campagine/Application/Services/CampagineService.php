<?php

namespace Domains\Campagine\Application\Services;

use Domains\Campagine\Application\Actions\CreateCampagineAction;
use Domains\Campagine\Application\Actions\UpdateCampagineAction;
use Domains\Campagine\Application\Actions\DeleteCampagineAction;
use Domains\Campagine\Application\Dto\CreateCampagineDto;
use Domains\Campagine\Application\Dto\UpdateCampagineDto;
use Domains\Campagine\Infrastructure\Persistence\Models\CampagineEloquent;
use Domains\Campagine\Domain\Entities\Campagine;

class CampagineService
{
    public function __construct(
        private readonly CreateCampagineAction $createAction,
        private readonly UpdateCampagineAction $updateAction,
        private readonly DeleteCampagineAction $deleteAction
    ) {}

    public function getAllCampaigns(): array
    {
        return CampagineEloquent::all()->toArray();
    }

    public function createCampaign(CreateCampagineDto $dto): Campagine
    {
        return ($this->createAction)($dto);
    }

    public function updateCampaign(int $id, UpdateCampagineDto $dto): Campagine
    {
        return ($this->updateAction)($id, $dto);
    }

    public function deleteCampaign(int $id): void
    {
        ($this->deleteAction)($id);
    }
}
