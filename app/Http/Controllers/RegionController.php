<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Support\CountryList;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegionController extends Controller
{
    public function index(Request $request): View
    {
        $search  = $request->get('search', '');
        $country = $request->get('country', '');

        $regions = Region::with('photos')
            ->when($search,  fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->when($country, fn($q) => $q->where('country', $country))
            ->orderBy('name')
            ->get();

        if ($request->ajax()) {
            return view('regions.partials.grid', compact('regions', 'search', 'country'));
        }

        $countries = $this->countriesWithRegions();

        return view('regions.index', compact('regions', 'search', 'country', 'countries'));
    }

    public function show(Region $region): View
    {
        $region->load(['photos', 'hikes.photos']);

        $photos = $region->photos->values();
        $mainPhoto = $photos->firstWhere('is_main', true) ?? $photos->first();
        $otherPhotos = $mainPhoto
            ? $photos->filter(fn($p) => $p->id !== $mainPhoto->id)->values()
            : collect();

        return view('regions.show', compact('region', 'photos', 'mainPhoto', 'otherPhotos'));
    }

    private function countriesWithRegions(): array
    {
        $all   = CountryList::get();
        $codes = Region::distinct()->orderBy('country')->pluck('country');

        return $codes->mapWithKeys(fn($code) => [$code => $all[$code] ?? $code])->all();
    }
}
