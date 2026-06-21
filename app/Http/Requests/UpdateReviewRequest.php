<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReviewRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'message'  => ['required', 'string', 'min:10', 'max:1000'],
            'rate'     => ['required', 'integer', 'between:1,5'],
            'photos'   => ['nullable', 'array', 'max:5'],
            'photos.*' => ['image', 'max:10240'],
        ];
    }
}
