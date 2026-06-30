<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;

class UserAdminProvider
{
    public function getFiltered(string $search): Collection
    {
        return User::where('is_admin', false)
            ->when($search, fn($q) => $q->where(fn($inner) =>
                $inner->where('email', 'like', "%{$search}%")
                      ->orWhere('nickname', 'like', "%{$search}%")
            ))
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
