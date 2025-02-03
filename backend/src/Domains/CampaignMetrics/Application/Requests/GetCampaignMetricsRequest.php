<?php

namespace Domains\CampaignMetrics\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Domains\CampaignMetrics\Application\Dto\GetCampaignMetricsDto;

class GetCampaignMetricsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function toDto(): GetCampaignMetricsDto
    {
        return GetCampaignMetricsDto::fromRequest($this->validated(),$this->route('campaignId'));
    }
}
