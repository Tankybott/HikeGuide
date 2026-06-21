<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Photo extends Model
{
    protected $fillable = [
        'path',
        'is_main',
        'context',
        'photoable_id',
        'photoable_type',
    ];

    protected function casts(): array
    {
        return [
            'is_main' => 'boolean',
        ];
    }

    public function photoable(): MorphTo
    {
        return $this->morphTo();
    }
}
