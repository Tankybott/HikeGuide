<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHikeDraftRequest;
use App\Models\Region;
use App\Services\HikeDraftCreator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HikeDraftController extends Controller
{
    public function __construct(private HikeDraftCreator $hikeDraftCreator) {}

    public function create(): View
    {
        $regions = Region::orderBy('name')->get();

        return view('drafts.create', compact('regions'));
    }

    public function store(StoreHikeDraftRequest $request): RedirectResponse
    {
        $data = $request->only([
            'region_id',
            'proposed_region_name',
            'proposed_region_description',
            'title',
            'description',
            'difficulty',
            'length_km',
        ]);

        $data['user_id'] = Auth::id();
        $data['has_parking'] = $request->boolean('has_parking');
        $data['is_parking_free'] = $request->boolean('is_parking_free');
        $data['needs_climbing_equipment'] = $request->boolean('needs_climbing_equipment');
        $data['needs_helmet'] = $request->boolean('needs_helmet');

        $this->hikeDraftCreator->create($data);

        return redirect()->route('hikes.index')->with('success', 'Your hike proposal has been submitted.');
    }
}
