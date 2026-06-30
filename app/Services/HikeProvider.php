<?php

namespace App\Services;

use App\Models\Hike;
use App\Models\Region;
use App\Support\CountryList;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class HikeProvider
{
    public function getFiltered(string $search, string $country): Collection
    {
        return Hike::with(['region', 'photos'])
            ->when($search,  fn($q) => $q->where('title', 'like', "%{$search}%"))
            ->when($country, fn($q) => $q->whereHas('region', fn($r) => $r->where('country', $country)))
            ->orderBy('title')
            ->get();
    }

    public function getCountriesWithHikes(): array
    {
        $all   = CountryList::get();
        $codes = Region::whereHas('hikes')->distinct()->orderBy('country')->pluck('country');

        return $codes->mapWithKeys(fn($code) => [$code => $all[$code] ?? $code])->all();
    }

    public function getShowData(Hike $hike): array
    {
        $hike->load(['photos', 'region', 'reviews.user', 'reviews.photos']);

        $photos    = $hike->photos->values();
        $mainPhoto = $photos->firstWhere('is_main', true) ?? $photos->first();

        $userReview = Auth::check()
            ? $hike->reviews->firstWhere('user_id', Auth::id())
            : null;

        $otherReviews = $hike->reviews
            ->when(Auth::check(), fn($c) => $c->where('user_id', '!=', Auth::id()))
            ->sortByDesc('created_at')
            ->values();

        return compact('photos', 'mainPhoto', 'userReview', 'otherReviews');
    }
}
