<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nickname' => ['required', 'string', 'min:3', 'max:255'],
        ];
    }
}
