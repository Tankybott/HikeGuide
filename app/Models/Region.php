<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Region extends Model
{
    protected $fillable = [
        'name',
        'country',
        'short_description',
        'description',
    ];

    public function hikes(): HasMany
    {
        return $this->hasMany(Hike::class);
    }

    public function photos(): MorphMany
    {
        return $this->morphMany(Photo::class, 'photoable');
    }
}
