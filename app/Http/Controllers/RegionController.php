<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Services\RegionProvider;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegionController extends Controller
{
    public function __construct(private RegionProvider $regionProvider) {}

    public function index(Request $request): View
    {
        $search  = $request->get('search', '');
        $country = $request->get('country', '');

        $regions = $this->regionProvider->getFiltered($search, $country);

        if ($request->ajax()) {
            return view('regions.partials.grid', compact('regions', 'search', 'country'));
        }

        $countries = $this->regionProvider->getCountriesWithRegions();

        return view('regions.index', compact('regions', 'search', 'country', 'countries'));
    }

    public function show(Region $region): View
    {
        $data = $this->regionProvider->getShowData($region);

        return view('regions.show', array_merge(compact('region'), $data));
    }
}
