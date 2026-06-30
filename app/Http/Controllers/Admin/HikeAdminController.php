<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHikeRequest;
use App\Http\Requests\UpdateHikeRequest;
use App\Models\Hike;
use App\Models\HikeDraft;
use App\Services\HikeAdminProvider;
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
        private HikeAdminProvider $hikeAdminProvider,
    ) {}

    public function index(Request $request): View
    {
        $search = $request->get('search', '');
        $hikes  = $this->hikeAdminProvider->getFiltered($search);

        if ($request->ajax()) {
            return view('admin.hikes.partials.table', compact('hikes', 'search'));
        }

        return view('admin.hikes.index', compact('hikes', 'search'));
    }

    public function create(Request $request): View
    {
        $data = $this->hikeAdminProvider->getCreateData(
            $request->filled('draft_id') ? $request->integer('draft_id') : null
        );

        return view('admin.hikes.form', array_merge($data, ['hike' => null]));
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
        $data = $this->hikeAdminProvider->getEditData($hike);

        return view('admin.hikes.form', array_merge($data, ['draft' => null]));
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
