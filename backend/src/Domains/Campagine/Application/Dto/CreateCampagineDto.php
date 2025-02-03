<?php

namespace Domains\Campagine\Application\Dto;

class CreateCampagineDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $status,
        public readonly float $dailyBudget,
        public readonly ?string $description,
        public readonly ?\DateTimeImmutable $startDate,
        public readonly ?\DateTimeImmutable $endDate
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            name: $data['name'],
            status: $data['status'],
            dailyBudget: (float) ($data['daily_budget'] ?? 0),
            description: $data['description'] ?? null,
            startDate: isset($data['start_date']) ? new \DateTimeImmutable($data['start_date']) : null,
            endDate: isset($data['end_date']) ? new \DateTimeImmutable($data['end_date']) : null
        );
    }
}
