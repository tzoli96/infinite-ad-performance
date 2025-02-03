<?php

namespace Domains\Campagine\Application\Requests;

use Domains\Campagine\Domain\Enums\CampaignStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Domains\Campagine\Application\Dto\UpdateCampagineDto;

class UpdateCampagineRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|unique:campaigns,name,' . $this->route('id'),
            'status' => ['sometimes', new Enum(CampaignStatus::class)],
            'daily_budget' => 'sometimes|numeric|min:0',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function toDto(): UpdateCampagineDto
    {
        return UpdateCampagineDto::fromRequest($this->validated());
    }
}
