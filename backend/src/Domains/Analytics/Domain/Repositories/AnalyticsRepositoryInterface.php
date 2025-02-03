<?php

namespace Domains\Analytics\Domain\Repositories;

interface AnalyticsRepositoryInterface
{
    public function getPerformanceMetrics(?\DateTimeImmutable $startDate, ?\DateTimeImmutable $endDate): array;
}
