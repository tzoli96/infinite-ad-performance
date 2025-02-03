<?php

use Domains\CampaignMetrics\Application\Services\CampaignMetricsService;
use Domains\CampaignMetrics\Application\Dto\CreateCampaignMetricsDto;
use Domains\CampaignMetrics\Application\Dto\GetCampaignMetricsDto;
use Domains\Campagine\Infrastructure\Persistence\Models\CampagineEloquent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    $this->serviceMock = Mockery::mock(CampaignMetricsService::class);
    App::instance(CampaignMetricsService::class, $this->serviceMock);
});

/**
 *  POST /api/campaign-metrics
 */
test('store creates a new campaign metric successfully', function () {
    $campaign = CampagineEloquent::factory()->create(['id' => 99]);

    $mockResponse = [
        'id' => 1,
        'campaign_id' => $campaign->id,
        'spend' => 100.00,
        'impressions' => 1000,
        'clicks' => 50,
        'conversions' => 5,
        'created_at' => now()->toISOString(),
        'date' => now()->toDateString(),
    ];

    $this->serviceMock->shouldReceive('store')
        ->once()
        ->with(Mockery::on(fn ($arg) => $arg instanceof CreateCampaignMetricsDto))
        ->andReturn($mockResponse);

    $response = $this->postJson('/api/campaign-metrics', [
        'campaign_id' => $campaign->id,
        'spend' => 100.00,
        'impressions' => 1000,
        'clicks' => 50,
        'conversions' => 5,
        'date' => now()->toDateString(),
    ]);


    $response->assertStatus(201)
        ->assertJson(fn ($json) =>
        $json->where('status', 'success')
            ->where('data.id', 1)
            ->where('data.campaign_id', 99)
            ->where('data.spend', fn ($value) => (float) $value === 100.00)
            ->where('data.impressions', 1000)
            ->where('data.clicks', 50)
            ->where('data.conversions', 5)
            ->etc()
        );
});

/**
 *  GET /api/campaign-metrics
 */
test('index retrieves campaign metrics successfully', function () {
    $mockResponse = [
        [
            'campaign_id' => 99,
            'spend' => 200.00,
            'impressions' => 5000,
            'clicks' => 100,
            'conversions' => 10,
        ],
        [
            'campaign_id' => 100,
            'spend' => 150.00,
            'impressions' => 3000,
            'clicks' => 80,
            'conversions' => 8,
        ],
    ];

    $this->serviceMock->shouldReceive('getMetrics')
        ->once()
        ->with(Mockery::on(fn ($arg) => $arg instanceof GetCampaignMetricsDto))
        ->andReturn($mockResponse);

    $response = $this->getJson('/api/campaign-metrics/1?start_date=2024-02-01&end_date=2024-02-10');

    $response->assertStatus(200)
        ->assertJson(fn ($json) =>
        $json->where('status', 'success')
            ->where('data.0.campaign_id', 99)
            ->where('data.0.spend', fn ($value) => (float) $value === 200.00)
            ->where('data.0.impressions', 5000)
            ->where('data.0.clicks', 100)
            ->where('data.0.conversions', 10)
            ->where('data.1.campaign_id', 100)
            ->where('data.1.spend', fn ($value) => (float) $value === 150.00)
            ->where('data.1.impressions', 3000)
            ->where('data.1.clicks', 80)
            ->where('data.1.conversions', 8)
            ->etc()
        );
});
