<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRegionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'size:2'],
            'short_description' => ['required', 'string', 'max:500'],
            'description' => ['required', 'string'],
            'photos' => ['nullable', 'array'],
            'photos.*' => ['image', 'max:5120'],
            'main_photo' => ['nullable', 'string'],
            'delete_photos' => ['nullable', 'array'],
            'delete_photos.*' => ['integer'],
        ];
    }
}
