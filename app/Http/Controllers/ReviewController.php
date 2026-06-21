<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Models\Hike;
use App\Models\Review;
use App\Services\ReviewCreator;
use App\Services\ReviewRemover;
use App\Services\ReviewUpdater;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct(
        private ReviewCreator $reviewCreator,
        private ReviewUpdater $reviewUpdater,
        private ReviewRemover $reviewRemover,
    ) {}

    public function store(StoreReviewRequest $request, Hike $hike): RedirectResponse
    {
        $this->reviewCreator->create($hike, Auth::id(), $request->validated(), $request->file('photos', []));

        return redirect()->route('hikes.show', $hike)->with('success', 'Review added.');
    }

    public function update(UpdateReviewRequest $request, Review $review): RedirectResponse
    {
        abort_if($review->user_id !== Auth::id(), 403);

        $this->reviewUpdater->update($review, $request->validated(), $request->file('photos', []));

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
