<?php

namespace Domains\Analytics\Application\Actions;

use Domains\Analytics\Application\Dto\GetAnalyticsDto;
use Domains\Analytics\Domain\Repositories\AnalyticsRepositoryInterface;
use Shared\Application\AbstractAction;
use InvalidArgumentException;

class GetAnalyticsAction extends AbstractAction
{
    public function __construct(private readonly AnalyticsRepositoryInterface $repository) {}

    public function __invoke(GetAnalyticsDto $dto): array
    {
        return $this->executeWithLogging(function () use ($dto) {
            $this->validateDateRange($dto->startDate, $dto->endDate);

            return $this->repository->getPerformanceMetrics($dto->startDate, $dto->endDate);
        }, 'GetAnalyticsAction');
    }

    private function validateDateRange(?\DateTimeImmutable $startDate, ?\DateTimeImmutable $endDate): void
    {
        if ($startDate && $endDate && $startDate > $endDate) {
            throw new InvalidArgumentException('Start date cannot be later than end date.');
        }
    }
}
