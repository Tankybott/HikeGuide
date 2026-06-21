<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHikeDraftRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'region_id' => ['nullable', 'integer', 'exists:regions,id'],
            'proposed_region_name' => ['nullable', 'string', 'max:255'],
            'proposed_region_description' => ['nullable', 'string', 'max:1000'],
            'title' => ['required', 'string', 'min:2', 'max:100'],
            'description' => ['required', 'string', 'min:100', 'max:1000'],
            'difficulty' => ['required', 'in:easy,moderate,hard'],
            'length_km' => ['nullable', 'numeric', 'gt:0'],
            'has_parking' => ['boolean'],
            'is_parking_free' => ['boolean'],
            'needs_climbing_equipment' => ['boolean'],
            'needs_helmet' => ['boolean'],
        ];
    }
}
