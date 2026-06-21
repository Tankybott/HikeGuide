<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'hike_id',
        'message',
        'rate',
    ];

    protected function casts(): array
    {
        return [
            'rate' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function hike(): BelongsTo
    {
        return $this->belongsTo(Hike::class);
    }

    public function photos(): MorphMany
    {
        return $this->morphMany(Photo::class, 'photoable');
    }
}
