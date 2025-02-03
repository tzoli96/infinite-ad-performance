<?php

namespace Domains\Campagine\Application\Actions;

use Domains\Campagine\Domain\Repositories\CampagineRepositoryInterface;
use Shared\Application\AbstractAction;
use InvalidArgumentException;

class DeleteCampagineAction extends AbstractAction
{
    public function __construct(private readonly CampagineRepositoryInterface $repository) {}

    public function __invoke(int $id): void
    {
        $this->executeWithLogging(function () use ($id) {
            $campagine = $this->repository->findById($id);

            if (!$campagine) {
                throw new InvalidArgumentException("Campaign with ID {$id} not found.");
            }

            $this->repository->delete($id);
        }, 'DeleteCampagineAction');
    }
}
