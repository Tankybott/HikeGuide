<?php

namespace App\Http\Controllers;

use App\Models\Hike;
use App\Models\Review;
use App\Services\ReviewCreator;
use App\Services\ReviewRemover;
use App\Services\ReviewUpdater;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct(
        private ReviewCreator $reviewCreator,
        private ReviewUpdater $reviewUpdater,
        private ReviewRemover $reviewRemover,
    ) {}

    public function store(Request $request, Hike $hike): RedirectResponse
    {
        $data = $request->validate([
            'message'  => ['required', 'string', 'min:10', 'max:1000'],
            'rate'     => ['required', 'integer', 'between:1,5'],
            'photos'   => ['nullable', 'array', 'max:5'],
            'photos.*' => ['image', 'max:10240'],
        ]);

        $this->reviewCreator->create($hike, Auth::id(), $data, $request->file('photos', []));

        return redirect()->route('hikes.show', $hike)->with('success', 'Review added.');
    }

    public function update(Request $request, Review $review): RedirectResponse
    {
        abort_if($review->user_id !== Auth::id(), 403);

        $data = $request->validate([
            'message'  => ['required', 'string', 'min:10', 'max:1000'],
            'rate'     => ['required', 'integer', 'between:1,5'],
            'photos'   => ['nullable', 'array', 'max:5'],
            'photos.*' => ['image', 'max:10240'],
        ]);

        $this->reviewUpdater->update($review, $data, $request->file('photos', []));

        return redirect()->route('hikes.show', $review->hike_id)->with('success', 'Review updated.');
    }

    public function destroy(Review $review): RedirectResponse
    {
        abort_if($review->user_id !== Auth::id() && !Auth::user()->is_admin, 403);

        $hikeId = $review->hike_id;
        $this->reviewRemover->remove($review);

        return redirect()->route('hikes.show', $hikeId)->with('success', 'Review deleted.');
    }
}
