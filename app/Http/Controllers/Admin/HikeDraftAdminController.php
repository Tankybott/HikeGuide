<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HikeDraft;
use App\Models\Region;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HikeDraftAdminController extends Controller
{
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

    public function bindRegion(Request $request, HikeDraft $draft): RedirectResponse
    {
        $request->validate([
            'region_id' => ['required', 'integer', 'exists:regions,id'],
        ]);

        $draft->update(['region_id' => $request->integer('region_id')]);

        return redirect()->route('admin.drafts.show', $draft)->with('success', 'Region linked to draft.');
    }

    public function destroy(HikeDraft $draft): RedirectResponse
    {
        $draft->delete();

        return redirect()->route('admin.drafts.index')->with('success', 'Draft deleted.');
    }
}
