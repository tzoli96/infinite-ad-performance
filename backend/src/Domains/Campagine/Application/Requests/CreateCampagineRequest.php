<?php

namespace Domains\Campagine\Application\Requests;

use Domains\Campagine\Domain\Enums\CampaignStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Domains\Campagine\Application\Dto\CreateCampagineDto;


class CreateCampagineRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:campaigns,name',
            'status' => ['required', new Enum(CampaignStatus::class)],
            'daily_budget' => 'required|numeric|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function toDto(): CreateCampagineDto
    {
        return CreateCampagineDto::fromRequest($this->validated());
    }
}
