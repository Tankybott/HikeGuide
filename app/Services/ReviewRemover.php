<?php

namespace App\Services;

use App\Models\Review;

class ReviewRemover
{
    public function __construct(private PhotoRemover $photoRemover) {}

    public function remove(Review $review): void
    {
        foreach ($review->photos as $photo) {
            $this->photoRemover->remove($photo);
        }

        $review->delete();
    }
}
