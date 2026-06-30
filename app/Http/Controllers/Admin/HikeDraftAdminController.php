<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BindDraftRegionRequest;
use App\Models\HikeDraft;
use App\Services\HikeDraftAdminProvider;
use App\Services\HikeDraftBinder;
use App\Services\HikeDraftRemover;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HikeDraftAdminController extends Controller
{
    public function __construct(
        private HikeDraftBinder $hikeDraftBinder,
        private HikeDraftRemover $hikeDraftRemover,
        private HikeDraftAdminProvider $hikeDraftAdminProvider,
    ) {}

    public function index(): View
    {
        $drafts = $this->hikeDraftAdminProvider->getAll();

        return view('admin.drafts.index', compact('drafts'));
    }

    public function show(HikeDraft $draft): View
    {
        $data = $this->hikeDraftAdminProvider->getShowData($draft);

        return view('admin.drafts.show', $data);
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
