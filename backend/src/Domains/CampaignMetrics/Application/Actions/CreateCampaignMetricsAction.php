<?php

namespace Domains\CampaignMetrics\Application\Actions;

use Domains\CampaignMetrics\Application\Dto\CreateCampaignMetricsDto;
use Domains\CampaignMetrics\Domain\Repositories\CampaignMetricsRepositoryInterface;
use Domains\CampaignMetrics\Domain\Entities\CampaignMetrics;
use Shared\Application\AbstractAction;

class CreateCampaignMetricsAction extends AbstractAction
{
    public function __construct(private readonly CampaignMetricsRepositoryInterface $repository) {}

    public function __invoke(CreateCampaignMetricsDto $dto): CampaignMetrics
    {
        return $this->executeWithLogging(function () use ($dto) {
            $metric = CampaignMetrics::create(
                campaignId: $dto->campaignId,
                date: $dto->date,
                impressions: $dto->impressions,
                clicks: $dto->clicks,
                spend: $dto->spend,
                conversions: $dto->conversions
            );

            return $this->repository->save($metric);
        }, 'CreateCampaignMetricsAction');
    }
}
