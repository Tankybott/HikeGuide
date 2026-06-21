<?php

namespace App\Services;

use App\Models\Review;

class ReviewUpdater
{
    public function __construct(
        private PhotoAttacher $photoAttacher,
        private PhotoRemover $photoRemover,
    ) {}

    public function update(Review $review, array $data, array $photos): void
    {
        $review->update(['message' => $data['message'], 'rate' => $data['rate']]);

        if ($photos) {
            foreach ($review->photos as $photo) {
                $this->photoRemover->remove($photo);
            }

            $this->photoAttacher->attach($review, $photos);
        }
    }
}
