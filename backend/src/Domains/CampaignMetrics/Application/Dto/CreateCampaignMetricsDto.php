<?php

namespace Domains\CampaignMetrics\Application\Dto;

class CreateCampaignMetricsDto
{
    public function __construct(
        public readonly int $campaignId,
        public readonly \DateTimeImmutable $date,
        public readonly int $impressions,
        public readonly int $clicks,
        public readonly float $spend,
        public readonly int $conversions
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            campaignId: $data['campaign_id'],
            date: new \DateTimeImmutable($data['date']),
            impressions: $data['impressions'],
            clicks: $data['clicks'],
            spend: $data['spend'],
            conversions: $data['conversions']
        );
    }
}
