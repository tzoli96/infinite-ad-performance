<?php

namespace Domains\CampaignMetrics\Application\Dto;

class GetCampaignMetricsDto
{
    public function __construct(
        public readonly int $campaignId,
        public readonly ?\DateTimeImmutable $startDate,
        public readonly ?\DateTimeImmutable $endDate
    ) {}

    public static function fromRequest(array $data, int $campaignId): self
    {
        return new self(
            campaignId: $campaignId,
            startDate: isset($data['start_date']) ? new \DateTimeImmutable($data['start_date']) : null,
            endDate: isset($data['end_date']) ? new \DateTimeImmutable($data['end_date']) : null
        );
    }
}
