<?php

namespace Domains\CampaignMetrics\Domain\Entities;

class CampaignMetrics
{
    public function __construct(
        public readonly ?int               $id,
        public readonly int                $campaignId,
        public readonly \DateTimeImmutable $date,
        public readonly int                $impressions,
        public readonly int                $clicks,
        public readonly float              $spend,
        public readonly int                $conversions
    )
    {
    }

    public static function create(
        int                $campaignId,
        \DateTimeImmutable $date,
        int                $impressions,
        int                $clicks,
        float              $spend,
        int                $conversions
    ): self
    {
        return new self(null, $campaignId, $date, $impressions, $clicks, $spend, $conversions);
    }
}
