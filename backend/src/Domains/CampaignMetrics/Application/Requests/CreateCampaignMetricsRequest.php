<?php

namespace Domains\CampaignMetrics\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Domains\CampaignMetrics\Application\Dto\CreateCampaignMetricsDto;

class CreateCampaignMetricsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'campaign_id' => 'required|exists:campaigns,id',
            'date' => 'required|date',
            'impressions' => 'required|integer|min:0',
            'clicks' => 'required|integer|min:0',
            'spend' => 'required|numeric|min:0',
            'conversions' => 'required|integer|min:0',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function toDto(): CreateCampaignMetricsDto
    {
        return CreateCampaignMetricsDto::fromRequest($this->validated());
    }
}
