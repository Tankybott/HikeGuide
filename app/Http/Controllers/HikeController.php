<?php

namespace App\Http\Controllers;

use App\Models\Hike;
use App\Services\HikeProvider;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HikeController extends Controller
{
    public function __construct(private HikeProvider $hikeProvider) {}

    public function index(Request $request): View
    {
        $search  = $request->get('search', '');
        $country = $request->get('country', '');

        $hikes = $this->hikeProvider->getFiltered($search, $country);

        if ($request->ajax()) {
            return view('hikes.partials.grid', compact('hikes', 'search', 'country'));
        }

        $countries = $this->hikeProvider->getCountriesWithHikes();

        return view('hikes.index', compact('hikes', 'search', 'country', 'countries'));
    }

    public function show(Hike $hike): View
    {
        $data = $this->hikeProvider->getShowData($hike);

        return view('hikes.show', array_merge(compact('hike'), $data));
    }
}
