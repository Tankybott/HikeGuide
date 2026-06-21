<?php

namespace App\Services;

use App\Models\Region;

class RegionRemover
{
    public function __construct(private PhotoRemover $photoRemover) {}

    public function remove(Region $region): void
    {
        foreach ($region->photos as $photo) {
            $this->photoRemover->remove($photo);
        }

        $region->delete();
    }
}
