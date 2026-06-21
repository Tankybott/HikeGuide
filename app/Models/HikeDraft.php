<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HikeDraft extends Model
{
    protected $fillable = [
        'user_id',
        'region_id',
        'proposed_region_name',
        'proposed_region_description',
        'title',
        'description',
        'difficulty',
        'length_km',
        'has_parking',
        'is_parking_free',
        'needs_climbing_equipment',
        'needs_helmet',
    ];

    protected function casts(): array
    {
        return [
            'has_parking' => 'boolean',
            'is_parking_free' => 'boolean',
            'needs_climbing_equipment' => 'boolean',
            'needs_helmet' => 'boolean',
            'length_km' => 'float',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }
}
