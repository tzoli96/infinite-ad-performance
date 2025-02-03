<?php

use Domains\Campagine\Application\Services\CampagineService;
use Domains\Campagine\Application\Dto\CreateCampagineDto;
use Domains\Campagine\Application\Dto\UpdateCampagineDto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Domains\Campagine\Domain\Entities\Campagine;
use Domains\Campagine\Domain\Enums\CampaignStatus;
use function Pest\Laravel\{get, post, put, delete};
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    $this->mockService = Mockery::mock(CampagineService::class);
    app()->instance(CampagineService::class, $this->mockService);
});

test('it can list campaigns', function () {
    $this->mockService
        ->shouldReceive('getAllCampaigns')
        ->once()
        ->andReturn([]);

    $response = get('/api/campaigns');

    $response->assertStatus(200)
        ->assertJson([]);
});

test('it can create a campaign', function () {
    $data = [
        'name' => 'Black Friday Sale',
        'status' => 'active',
        'daily_budget' => 100.0,
        'start_date' => '2024-11-01',
        'end_date' => '2024-12-01'
    ];

    $campaign = new Campagine(
        id: 1,
        name: 'Black Friday Sale',
        status: CampaignStatus::ACTIVE,
        dailyBudget: 100.0,
        startDate: new \DateTimeImmutable('2024-11-01'),
        endDate: new \DateTimeImmutable('2024-12-01'),
        createdAt: new \DateTimeImmutable(),
        updatedAt: new \DateTimeImmutable()
    );

    $this->mockService
        ->shouldReceive('createCampaign')
        ->once()
        ->with(Mockery::type(CreateCampagineDto::class))
        ->andReturn($campaign);

    $response = post('/api/campaigns', $data);


    $response->assertStatus(201)
        ->assertJson([
            'status' => 'success',
            'data' => [
                'id' => 1,
                'name' => 'Black Friday Sale',
                'status' => 'active',
                'dailyBudget' => 100.0,
                'startDate' => ['date' => '2024-11-01 00:00:00.000000'],
                'endDate' => ['date' => '2024-12-01 00:00:00.000000'],
            ]
        ]);
});



test('it can update a campaign', function () {
    $data = [
        'name' => 'Cyber Monday Sale',
        'status' => 'paused',
        'daily_budget' => 150.0,
        'start_date' => '2024-12-01',
        'end_date' => '2024-12-10'
    ];

    $campaign = new Campagine(
        id: 1,
        name: 'Cyber Monday Sale',
        status: CampaignStatus::PAUSED,
        dailyBudget: 150.0,
        startDate: new \DateTimeImmutable('2024-12-01'),
        endDate: new \DateTimeImmutable('2024-12-10'),
        createdAt: new \DateTimeImmutable(),
        updatedAt: new \DateTimeImmutable()
    );

    $this->mockService
        ->shouldReceive('updateCampaign')
        ->once()
        ->with(1, Mockery::type(UpdateCampagineDto::class))
        ->andReturn($campaign);

    $response = put('/api/campaigns/1', $data);

    $response->assertStatus(200)
        ->assertJson([
            'status' => 'success',
            'data' => [
                'id' => 1,
                'name' => 'Cyber Monday Sale',
                'status' => 'paused',
                'dailyBudget' => 150.0,
                'startDate' => ['date' => '2024-12-01 00:00:00.000000'],
                'endDate' => ['date' => '2024-12-10 00:00:00.000000'],
            ]
        ]);
});


test('it can delete a campaign', function () {
    $this->mockService
        ->shouldReceive('deleteCampaign')
        ->once()
        ->with(1)
        ->andReturnNull();

    $response = delete('/api/campaigns/1');

    $response->assertStatus(200)
        ->assertJsonPath('data.message', 'Campaign deleted');
});

