<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Hike extends Model
{
    protected $fillable = [
        'region_id',
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

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function photos(): MorphMany
    {
        return $this->morphMany(Photo::class, 'photoable');
    }
}
