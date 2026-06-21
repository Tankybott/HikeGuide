<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegionRequest;
use App\Http\Requests\UpdateRegionRequest;
use App\Models\HikeDraft;
use App\Models\Region;
use App\Services\HikeDraftBinder;
use App\Services\RegionCreator;
use App\Services\RegionRemover;
use App\Services\RegionUpdater;
use App\Support\CountryList;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegionAdminController extends Controller
{
    public function __construct(
        private RegionCreator $regionCreator,
        private RegionUpdater $regionUpdater,
        private RegionRemover $regionRemover,
        private HikeDraftBinder $hikeDraftBinder,
    ) {}

    public function index(Request $request): View
    {
        $search = $request->get('search', '');

        $regions = Region::when($search, fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->orderBy('name')
            ->get();

        if ($request->ajax()) {
            return view('admin.regions.partials.table', compact('regions', 'search'));
        }

        return view('admin.regions.index', compact('regions', 'search'));
    }

    public function create(Request $request): View
    {
        $countries = CountryList::get();
        $draft = $request->filled('draft_id') ? HikeDraft::find($request->integer('draft_id')) : null;

        return view('admin.regions.form', ['region' => null, 'countries' => $countries, 'draft' => $draft]);
    }

    public function store(StoreRegionRequest $request): RedirectResponse
    {
        $region = $this->regionCreator->create(
            $request->only(['name', 'country', 'short_description', 'description']),
            $request->file('photos', []),
            $request->input('main_photo'),
        );

        if ($request->filled('draft_id')) {
            $draft = HikeDraft::find($request->integer('draft_id'));
            if ($draft) {
                $this->hikeDraftBinder->bind($draft, $region->id);
                return redirect()->route('admin.drafts.show', $draft)->with('success', 'Region created and linked to draft.');
            }
        }

        return redirect()->route('admin.regions.index')->with('success', 'Region created.');
    }

    public function edit(Region $region): View
    {
        $region->load('photos');
        $countries = CountryList::get();

        return view('admin.regions.form', ['region' => $region, 'countries' => $countries, 'draft' => null]);
    }

    public function update(UpdateRegionRequest $request, Region $region): RedirectResponse
    {
        $this->regionUpdater->update(
            $region,
            $request->only(['name', 'country', 'short_description', 'description']),
            $request->file('photos', []),
            $request->input('delete_photos', []),
            $request->input('main_photo'),
        );

        return redirect()->route('admin.regions.index')->with('success', 'Region updated.');
    }

    public function destroy(Region $region): RedirectResponse
    {
        $this->regionRemover->remove($region);

        return redirect()->route('admin.regions.index')->with('success', 'Region deleted.');
    }
}
