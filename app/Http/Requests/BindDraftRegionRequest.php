<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BindDraftRegionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'region_id' => ['required', 'integer', 'exists:regions,id'],
        ];
    }
}
