<?php

namespace App\Services;

use App\Models\Region;
use App\Support\CountryList;
use Illuminate\Support\Collection;

class RegionProvider
{
    public function getFiltered(string $search, string $country): Collection
    {
        return Region::with('photos')
            ->when($search,  fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->when($country, fn($q) => $q->where('country', $country))
            ->orderBy('name')
            ->get();
    }

    public function getCountriesWithRegions(): array
    {
        $all   = CountryList::get();
        $codes = Region::distinct()->orderBy('country')->pluck('country');

        return $codes->mapWithKeys(fn($code) => [$code => $all[$code] ?? $code])->all();
    }

    public function getShowData(Region $region): array
    {
        $region->load(['photos', 'hikes.photos']);

        $photos      = $region->photos->values();
        $mainPhoto   = $photos->firstWhere('is_main', true) ?? $photos->first();
        $otherPhotos = $mainPhoto
            ? $photos->filter(fn($p) => $p->id !== $mainPhoto->id)->values()
            : collect();

        return compact('photos', 'mainPhoto', 'otherPhotos');
    }
}
