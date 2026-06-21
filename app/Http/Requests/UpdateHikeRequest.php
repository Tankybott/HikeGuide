<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHikeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'region_id' => ['required', 'integer', 'exists:regions,id'],
            'title' => ['required', 'string', 'min:2', 'max:100'],
            'description' => ['required', 'string', 'min:100', 'max:1000'],
            'difficulty' => ['required', 'in:easy,moderate,hard'],
            'length_km' => ['nullable', 'numeric', 'gt:0'],
            'has_parking' => ['boolean'],
            'is_parking_free' => ['boolean'],
            'needs_climbing_equipment' => ['boolean'],
            'needs_helmet' => ['boolean'],
            'photos' => ['nullable', 'array'],
            'photos.*' => ['image', 'max:5120'],
            'main_photo' => ['nullable', 'string'],
            'delete_photos' => ['nullable', 'array'],
            'delete_photos.*' => ['integer'],
        ];
    }
}
