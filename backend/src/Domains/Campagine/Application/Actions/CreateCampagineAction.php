<?php

namespace Domains\Campagine\Application\Actions;

use Domains\Campagine\Application\Dto\CreateCampagineDto;
use Domains\Campagine\Domain\Repositories\CampagineRepositoryInterface;
use Domains\Campagine\Domain\Entities\Campagine;
use Domains\Campagine\Domain\Enums\CampaignStatus;
use Shared\Application\AbstractAction;

class CreateCampagineAction extends AbstractAction
{
    public function __construct(private readonly CampagineRepositoryInterface $repository) {}

    public function __invoke(CreateCampagineDto $dto): Campagine
    {
        return $this->executeWithLogging(fn() => $this->repository->save(
            Campagine::create(
                name: $dto->name,
                status: CampaignStatus::from($dto->status),
                dailyBudget: $dto->dailyBudget,
                startDate: $dto->startDate,
                endDate: $dto->endDate
            )
        ), 'CreateCampagineAction');
    }
}
