<?php

namespace Domains\Campagine\Domain\Entities;

use Domains\Campagine\Domain\Enums\CampaignStatus;

class Campagine
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly CampaignStatus $status,
        public readonly float $dailyBudget,
        public readonly ?\DateTimeImmutable $startDate,
        public readonly ?\DateTimeImmutable $endDate,
        public readonly ?\DateTimeImmutable $createdAt = null,
        public readonly ?\DateTimeImmutable $updatedAt = null
    ) {}

    public static function create(
        string $name,
        CampaignStatus $status = CampaignStatus::PAUSED,
        float $dailyBudget,
        ?\DateTimeImmutable $startDate,
        ?\DateTimeImmutable $endDate
    ): self {
        return new self(
            null,
            $name,
            $status,
            $dailyBudget,
            $startDate,
            $endDate
        );
    }
}
