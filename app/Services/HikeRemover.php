<?php

namespace App\Services;

use App\Models\Hike;

class HikeRemover
{
    public function __construct(private PhotoRemover $photoRemover) {}

    public function remove(Hike $hike): void
    {
        foreach ($hike->photos as $photo) {
            $this->photoRemover->remove($photo);
        }

        $hike->delete();
    }
}
