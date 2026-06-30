<?php

namespace App\Services;

use App\Models\HikeDraft;
use App\Models\Region;
use App\Support\CountryList;
use Illuminate\Support\Collection;

class RegionAdminProvider
{
    public function getFiltered(string $search): Collection
    {
        return Region::when($search, fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->orderBy('name')
            ->get();
    }

    public function getCreateData(?int $draftId): array
    {
        $countries = CountryList::get();
        $draft     = $draftId ? HikeDraft::find($draftId) : null;

        return compact('countries', 'draft');
    }

    public function getEditData(Region $region): array
    {
        $region->load('photos');
        $countries = CountryList::get();

        return compact('region', 'countries');
    }
}
