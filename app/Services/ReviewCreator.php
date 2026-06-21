<?php

namespace App\Services;

use App\Models\Hike;
use App\Models\Review;

class ReviewCreator
{
    public function __construct(private PhotoAttacher $photoAttacher) {}

    public function create(Hike $hike, int $userId, array $data, array $photos): Review
    {
        $review = $hike->reviews()->create([
            'user_id' => $userId,
            'message' => $data['message'],
            'rate'    => $data['rate'],
        ]);

        if ($photos) {
            $this->photoAttacher->attach($review, $photos);
        }

        return $review;
    }
}
