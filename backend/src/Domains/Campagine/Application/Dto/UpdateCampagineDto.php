<?php

namespace Domains\Campagine\Application\Dto;

use Domains\Campagine\Domain\Enums\CampaignStatus;

class UpdateCampagineDto
{
    public function __construct(
        public readonly ?int                $id,
        public readonly string              $name,
        public readonly string              $status,
        public readonly float               $dailyBudget,
        public readonly ?\DateTimeImmutable $startDate,
        public readonly ?\DateTimeImmutable $endDate
    )
    {
    }

    public static function fromRequest(array $data): self
    {
        return new self(
            id: $data["id"] ?? null,
            name: $data['name'] ?? null,
            status: $data['status'] ?? null,
            dailyBudget: isset($data['daily_budget']) ? (float)$data['daily_budget'] : null,
            startDate: isset($data['start_date']) ? new \DateTimeImmutable($data['start_date']) : null,
            endDate: isset($data['end_date']) ? new \DateTimeImmutable($data['end_date']) : null
        );
    }

    public function updateWithDto(UpdateCampagineDto $dto): self
    {
        return new self(
            id: $this->id,
            name: $dto->name ?? $this->name,
            status: $dto->status ?? $this->status,
            dailyBudget: $dto->dailyBudget ?? $this->dailyBudget,
            startDate: $dto->startDate ?? $this->startDate,
            endDate: $dto->endDate ?? $this->endDate
        );
    }
}
