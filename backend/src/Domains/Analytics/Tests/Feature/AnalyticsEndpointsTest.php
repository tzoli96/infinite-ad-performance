<?php

use Domains\Analytics\Application\Services\AnalyticsService;
use Domains\Analytics\Application\Dto\GetAnalyticsDto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class, WithFaker::class);

beforeEach(function () {
    $this->serviceMock = Mockery::mock(AnalyticsService::class);
    App::instance(AnalyticsService::class, $this->serviceMock);
});

test('getPerformanceMetrics returns a successful response', function () {

    $mockResponse = [
        'total_spend' => 1200.50,
        'total_conversions' => 34,
        'ctr' => '4.5%',
        'conversion_rate' => '2.8%',
    ];

    $this->serviceMock->shouldReceive('getPerformanceData')
        ->once()
        ->with(Mockery::on(fn ($arg) => $arg instanceof GetAnalyticsDto))
        ->andReturn($mockResponse);

    $response = $this->getJson('/api/analytics/performance?start_date=2024-02-01&end_date=2024-02-10');

    $response->assertStatus(201)
    ->assertJson(fn ($json) =>
    $json->where('status', 'success')
        ->where('data.total_spend', 1200.50)
        ->where('data.total_conversions', 34)
        ->where('data.ctr', '4.5%')
        ->where('data.conversion_rate', '2.8%')
        ->etc()
    );
});

