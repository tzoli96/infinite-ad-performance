<?php

use Illuminate\Support\Facades\Route;
use Domains\Campagine\Application\Controllers\CampagineController;
use Domains\CampaignMetrics\Application\Controllers\CampaignMetricsController;
use Domains\Analytics\Application\Controllers\AnalyticsController;

Route::prefix('campaigns')->group(function () {
    Route::get('/', [CampagineController::class, 'index']);
    Route::post('/', [CampagineController::class, 'store']);
    Route::put('/{id}', [CampagineController::class, 'update']);
    Route::delete('/{id}', [CampagineController::class, 'destroy']);
});

Route::prefix('campaign-metrics')->group(function () {
    Route::post('/', [CampaignMetricsController::class, 'store']);
    Route::get('/{campaignId}', [CampaignMetricsController::class, 'index']);
});

Route::get('/analytics/performance', [AnalyticsController::class, 'getPerformanceMetrics']);
