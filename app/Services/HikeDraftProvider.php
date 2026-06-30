<?php

namespace App\Services;

use App\Models\Region;

class HikeDraftProvider
{
    public function getCreateData(): array
    {
        $regions = Region::orderBy('name')->get();

        return compact('regions');
    }
}
