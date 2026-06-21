<?php

namespace App\Services;

use App\Models\Hike;

class HikeUpdater
{
    public function __construct(
        private PhotoAttacher $photoAttacher,
        private PhotoRemover $photoRemover,
    ) {}

    public function update(Hike $hike, array $data, array $newPhotos = [], array $deletePhotoIds = [], ?string $mainPhoto = null): Hike
    {
        $hike->update($data);

        foreach ($deletePhotoIds as $photoId) {
            $photo = $hike->photos()->find($photoId);
            if ($photo) {
                $this->photoRemover->remove($photo);
            }
        }

        $hike->unsetRelation('photos');

        foreach ($hike->photos as $photo) {
            $photo->update(['is_main' => (string) $photo->id === (string) $mainPhoto]);
        }

        $this->photoAttacher->attach($hike, $newPhotos, $mainPhoto);

        $hike->unsetRelation('photos');

        if ($hike->photos()->exists() && !$hike->photos()->where('is_main', true)->exists()) {
            $hike->photos()->first()->update(['is_main' => true]);
        }

        return $hike;
    }
}
