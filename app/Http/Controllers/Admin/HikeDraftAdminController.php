<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BindDraftRegionRequest;
use App\Models\HikeDraft;
use App\Models\Region;
use App\Services\HikeDraftBinder;
use App\Services\HikeDraftRemover;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HikeDraftAdminController extends Controller
{
    public function __construct(
        private HikeDraftBinder $hikeDraftBinder,
        private HikeDraftRemover $hikeDraftRemover,
    ) {}

    public function index(): View
    {
        $drafts = HikeDraft::with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.drafts.index', compact('drafts'));
    }

    public function show(HikeDraft $draft): View
    {
        $draft->load(['user', 'region']);
        $regions = Region::orderBy('name')->get();

        return view('admin.drafts.show', compact('draft', 'regions'));
    }

    public function bindRegion(BindDraftRegionRequest $request, HikeDraft $draft): RedirectResponse
    {
        $this->hikeDraftBinder->bind($draft, $request->integer('region_id'));

        return redirect()->route('admin.drafts.show', $draft)->with('success', 'Region linked to draft.');
    }

    public function destroy(HikeDraft $draft): RedirectResponse
    {
        $this->hikeDraftRemover->remove($draft);

        return redirect()->route('admin.drafts.index')->with('success', 'Draft deleted.');
    }
}
