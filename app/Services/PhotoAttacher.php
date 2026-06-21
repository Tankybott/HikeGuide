<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class PhotoAttacher
{
    public function attach(Model $model, array $files, ?string $mainPhoto = null, ?string $context = null): void
    {
        foreach ($files as $index => $file) {
            /** @var UploadedFile $file */
            $path = $file->store('photos', 'public');

            $model->photos()->create([
                'path' => $path,
                'is_main' => $mainPhoto === "new_{$index}",
                'context' => $context,
            ]);
        }
    }
}
