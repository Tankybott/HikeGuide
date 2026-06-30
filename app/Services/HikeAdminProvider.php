<?php

namespace App\Services;

use App\Models\Hike;
use App\Models\HikeDraft;
use App\Models\Region;
use Illuminate\Support\Collection;

class HikeAdminProvider
{
    public function getFiltered(string $search): Collection
    {
        return Hike::with('region')
            ->when($search, fn($q) => $q->where('title', 'like', "%{$search}%"))
            ->orderBy('title')
            ->get();
    }

    public function getCreateData(?int $draftId): array
    {
        $regions = Region::orderBy('name')->get();
        $draft   = $draftId ? HikeDraft::find($draftId) : null;

        return compact('regions', 'draft');
    }

    public function getEditData(Hike $hike): array
    {
        $hike->load('photos');
        $regions = Region::orderBy('name')->get();

        return compact('hike', 'regions');
    }
}
