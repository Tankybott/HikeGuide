<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserAdminProvider;
use App\Services\UserBanner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserAdminController extends Controller
{
    public function __construct(
        private UserBanner $userBanner,
        private UserAdminProvider $userAdminProvider,
    ) {}

    public function index(Request $request): View
    {
        $search = $request->get('search', '');
        $users  = $this->userAdminProvider->getFiltered($search);

        return view('admin.users.index', compact('users', 'search'));
    }

    public function ban(User $user): RedirectResponse
    {
        abort_if($user->is_admin, 403);

        $this->userBanner->ban($user);

        return redirect()->route('admin.users.index')->with('success', "{$user->nickname} has been banned.");
    }

    public function unban(User $user): RedirectResponse
    {
        abort_if($user->is_admin, 403);

        $this->userBanner->unban($user);

        return redirect()->route('admin.users.index')->with('success', "{$user->nickname} has been unbanned.");
    }
}
