<?php

namespace App\Http\Controllers;

use App\Models\Hike;
use App\Models\Region;
use App\Support\CountryList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HikeController extends Controller
{
    public function index(Request $request): View
    {
        $search  = $request->get('search', '');
        $country = $request->get('country', '');

        $hikes = Hike::with(['region', 'photos'])
            ->when($search,  fn($q) => $q->where('title', 'like', "%{$search}%"))
            ->when($country, fn($q) => $q->whereHas('region', fn($r) => $r->where('country', $country)))
            ->orderBy('title')
            ->get();

        if ($request->ajax()) {
            return view('hikes.partials.grid', compact('hikes', 'search', 'country'));
        }

        $countries = $this->countriesWithHikes();

        return view('hikes.index', compact('hikes', 'search', 'country', 'countries'));
    }

    public function show(Hike $hike): View
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

        return view('hikes.show', compact('hike', 'photos', 'mainPhoto', 'userReview', 'otherReviews'));
    }

    private function countriesWithHikes(): array
    {
        $all   = CountryList::get();
        $codes = Region::whereHas('hikes')->distinct()->orderBy('country')->pluck('country');

        return $codes->mapWithKeys(fn($code) => [$code => $all[$code] ?? $code])->all();
    }
}
