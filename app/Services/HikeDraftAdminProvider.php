<?php

namespace App\Services;

use App\Models\HikeDraft;
use App\Models\Region;
use Illuminate\Support\Collection;

class HikeDraftAdminProvider
{
    public function getAll(): Collection
    {
        return HikeDraft::with('user')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getShowData(HikeDraft $draft): array
    {
        $draft->load(['user', 'region']);
        $regions = Region::orderBy('name')->get();

        return compact('draft', 'regions');
    }
}
