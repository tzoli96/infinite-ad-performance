<?php

namespace Domains\Analytics\Application\Dto;

class GetAnalyticsDto
{
    public function __construct(
        public readonly ?\DateTimeImmutable $startDate,
        public readonly ?\DateTimeImmutable $endDate
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            startDate: isset($data['start_date']) ? new \DateTimeImmutable($data['start_date']) : null,
            endDate: isset($data['end_date']) ? new \DateTimeImmutable($data['end_date']) : null
        );
    }
}
