<?php

namespace App\Services;

use App\Models\User;

class UserBanner
{
    public function ban(User $user): void
    {
        $user->is_banned = true;
        $user->save();
    }

    public function unban(User $user): void
    {
        $user->is_banned = false;
        $user->save();
    }
}
