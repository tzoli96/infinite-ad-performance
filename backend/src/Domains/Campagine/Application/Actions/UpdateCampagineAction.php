<?php

namespace Domains\Campagine\Application\Actions;

use Domains\Campagine\Application\Dto\UpdateCampagineDto;
use Domains\Campagine\Domain\Repositories\CampagineRepositoryInterface;
use Domains\Campagine\Domain\Entities\Campagine;
use Domains\Campagine\Domain\Enums\CampaignStatus;
use Shared\Application\AbstractAction;
use InvalidArgumentException;

class UpdateCampagineAction extends AbstractAction
{
    public function __construct(private readonly CampagineRepositoryInterface $repository) {}

    public function __invoke(int $id, UpdateCampagineDto $dto): Campagine
    {
        return $this->executeWithLogging(function () use ($id, $dto) {
            $campagine = $this->repository->findById($id);

            if (!$campagine) {
                throw new InvalidArgumentException("Campaign with ID {$id} not found.");
            }

            if ($dto->status && !CampaignStatus::isValid($dto->status)) {
                throw new InvalidArgumentException("Invalid campaign status: {$dto->status}");
            }

            return $this->repository->save($dto->updateWithDto($dto));
        }, 'UpdateCampagineAction');
    }
}
