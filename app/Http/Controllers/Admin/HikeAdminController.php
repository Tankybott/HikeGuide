<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHikeRequest;
use App\Http\Requests\UpdateHikeRequest;
use App\Models\Hike;
use App\Models\HikeDraft;
use App\Models\Region;
use App\Services\HikeCreator;
use App\Services\HikeDraftRemover;
use App\Services\HikeRemover;
use App\Services\HikeUpdater;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HikeAdminController extends Controller
{
    public function __construct(
        private HikeCreator $hikeCreator,
        private HikeUpdater $hikeUpdater,
        private HikeRemover $hikeRemover,
        private HikeDraftRemover $hikeDraftRemover,
    ) {}

    public function index(Request $request): View
    {
        $search = $request->get('search', '');

        $hikes = Hike::with('region')
            ->when($search, fn($q) => $q->where('title', 'like', "%{$search}%"))
            ->orderBy('title')
            ->get();

        if ($request->ajax()) {
            return view('admin.hikes.partials.table', compact('hikes', 'search'));
        }

        return view('admin.hikes.index', compact('hikes', 'search'));
    }

    public function create(Request $request): View
    {
        $regions = Region::orderBy('name')->get();
        $draft = $request->filled('draft_id') ? HikeDraft::find($request->integer('draft_id')) : null;

        return view('admin.hikes.form', ['hike' => null, 'regions' => $regions, 'draft' => $draft]);
    }

    public function store(StoreHikeRequest $request): RedirectResponse
    {
        $data = $request->only(['region_id', 'title', 'description', 'difficulty', 'length_km']);
        $data['has_parking'] = $request->boolean('has_parking');
        $data['is_parking_free'] = $request->boolean('is_parking_free');
        $data['needs_climbing_equipment'] = $request->boolean('needs_climbing_equipment');
        $data['needs_helmet'] = $request->boolean('needs_helmet');

        $this->hikeCreator->create($data, $request->file('photos', []), $request->input('main_photo'));

        if ($request->filled('draft_id')) {
            $draft = HikeDraft::find($request->integer('draft_id'));
            if ($draft) {
                $this->hikeDraftRemover->remove($draft);
            }
        }

        return redirect()->route('admin.hikes.index')->with('success', 'Hike created.');
    }

    public function edit(Hike $hike): View
    {
        $hike->load('photos');
        $regions = Region::orderBy('name')->get();

        return view('admin.hikes.form', ['hike' => $hike, 'regions' => $regions, 'draft' => null]);
    }

    public function update(UpdateHikeRequest $request, Hike $hike): RedirectResponse
    {
        $data = $request->only(['region_id', 'title', 'description', 'difficulty', 'length_km']);
        $data['has_parking'] = $request->boolean('has_parking');
        $data['is_parking_free'] = $request->boolean('is_parking_free');
        $data['needs_climbing_equipment'] = $request->boolean('needs_climbing_equipment');
        $data['needs_helmet'] = $request->boolean('needs_helmet');

        $this->hikeUpdater->update($hike, $data, $request->file('photos', []), $request->input('delete_photos', []), $request->input('main_photo'));

        return redirect()->route('admin.hikes.index')->with('success', 'Hike updated.');
    }

    public function destroy(Hike $hike): RedirectResponse
    {
        $this->hikeRemover->remove($hike);

        return redirect()->route('admin.hikes.index')->with('success', 'Hike deleted.');
    }
}
