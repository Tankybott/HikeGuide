<?php

namespace App\Services;

use App\Models\Hike;

class HikeCreator
{
    public function __construct(private PhotoAttacher $photoAttacher) {}

    public function create(array $data, array $photos = [], ?string $mainPhoto = null): Hike
    {
        $hike = Hike::create($data);

        $this->photoAttacher->attach($hike, $photos, $mainPhoto);

        if (!empty($photos) && !$hike->photos()->where('is_main', true)->exists()) {
            $hike->photos()->first()?->update(['is_main' => true]);
        }

        return $hike;
    }
}
