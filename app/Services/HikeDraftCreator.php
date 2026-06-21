<?php

namespace App\Services;

use App\Models\HikeDraft;

class HikeDraftCreator
{
    public function create(array $data): HikeDraft
    {
        return HikeDraft::create($data);
    }
}
