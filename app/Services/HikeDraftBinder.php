<?php

namespace App\Services;

use App\Models\HikeDraft;

class HikeDraftBinder
{
    public function bind(HikeDraft $draft, int $regionId): void
    {
        $draft->update(['region_id' => $regionId]);
    }
}
