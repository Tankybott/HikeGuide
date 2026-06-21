<?php

namespace App\Services;

use App\Models\Region;

class RegionUpdater
{
    public function __construct(
        private PhotoAttacher $photoAttacher,
        private PhotoRemover $photoRemover,
    ) {}

    public function update(Region $region, array $data, array $newPhotos = [], array $deletePhotoIds = [], ?string $mainPhoto = null): Region
    {
        $region->update($data);

        foreach ($deletePhotoIds as $photoId) {
            $photo = $region->photos()->find($photoId);
            if ($photo) {
                $this->photoRemover->remove($photo);
            }
        }

        $region->unsetRelation('photos');

        foreach ($region->photos as $photo) {
            $photo->update(['is_main' => (string) $photo->id === (string) $mainPhoto]);
        }

        $this->photoAttacher->attach($region, $newPhotos, $mainPhoto);

        $region->unsetRelation('photos');

        if ($region->photos()->exists() && !$region->photos()->where('is_main', true)->exists()) {
            $region->photos()->first()->update(['is_main' => true]);
        }

        return $region;
    }
}
