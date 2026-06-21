<?php

namespace App\Services;

use App\Models\Photo;
use Illuminate\Support\Facades\Storage;

class PhotoRemover
{
    public function remove(Photo $photo): void
    {
        Storage::disk('public')->delete($photo->path);
        $photo->delete();
    }
}
