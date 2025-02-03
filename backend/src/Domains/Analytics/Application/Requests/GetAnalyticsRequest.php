<?php

namespace Domains\Analytics\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Domains\Analytics\Application\Dto\GetAnalyticsDto;

class GetAnalyticsRequest extends FormRequest
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

    public function toDto(): GetAnalyticsDto
    {
        return GetAnalyticsDto::fromRequest($this->validated());
    }
}
