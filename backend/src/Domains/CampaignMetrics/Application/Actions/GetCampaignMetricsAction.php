<?php

namespace Domains\CampaignMetrics\Application\Actions;

use Domains\CampaignMetrics\Application\Dto\GetCampaignMetricsDto;
use Domains\CampaignMetrics\Domain\Repositories\CampaignMetricsRepositoryInterface;
use Shared\Application\AbstractAction;
use InvalidArgumentException;

class GetCampaignMetricsAction extends AbstractAction
{
    public function __construct(private readonly CampaignMetricsRepositoryInterface $repository) {}

    public function __invoke(GetCampaignMetricsDto $dto): array
    {
        return $this->executeWithLogging(function () use ($dto) {
            if (!$dto->campaignId) {
                throw new InvalidArgumentException("Campaign ID is required to fetch metrics.");
            }

            return $this->repository->getMetricsByCampaign(
                $dto->campaignId,
                $dto->startDate,
                $dto->endDate
            );
        }, 'GetCampaignMetricsAction');
    }
}
