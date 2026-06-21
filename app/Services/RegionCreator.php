<?php

namespace App\Services;

use App\Models\Region;

class RegionCreator
{
    public function __construct(private PhotoAttacher $photoAttacher) {}

    public function create(array $data, array $photos = [], ?string $mainPhoto = null): Region
    {
        $region = Region::create($data);

        $this->photoAttacher->attach($region, $photos, $mainPhoto);

        if (!empty($photos) && !$region->photos()->where('is_main', true)->exists()) {
            $region->photos()->first()?->update(['is_main' => true]);
        }

        return $region;
    }
}
