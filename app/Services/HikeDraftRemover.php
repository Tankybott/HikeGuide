<?php

namespace App\Services;

use App\Models\HikeDraft;

class HikeDraftRemover
{
    public function remove(HikeDraft $draft): void
    {
        $draft->delete();
    }
}
