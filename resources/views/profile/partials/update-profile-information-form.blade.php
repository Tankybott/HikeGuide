<section>
    <h2 class="text-lg font-semibold text-gray-900">Profile Information</h2>
    <p class="mt-1 text-sm text-gray-500">Update your display nickname.</p>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-5">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="nickname" :value="__('Nickname')" />
            <x-text-input id="nickname" name="nickname" type="text" class="mt-1" :value="old('nickname', $user->nickname)" required autofocus />
            <x-input-error class="mt-2" :messages="$errors->get('nickname')" />
        </div>

        <div>
            <x-input-label :value="__('Email')" />
            <p class="mt-1 text-sm text-gray-600 bg-gray-50 border border-gray-200 rounded-lg px-3 py-2">{{ $user->email }}</p>
            <p class="mt-1 text-xs text-gray-400">Email address cannot be changed.</p>

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-amber-700 bg-amber-50 border border-amber-200 rounded-lg px-3 py-2">
                        Your email address is unverified.
                        <form id="send-verification" method="post" action="{{ route('verification.send') }}" class="inline">
                            @csrf
                            <button type="submit" class="underline hover:text-amber-900 transition-colors">Resend verification email.</button>
                        </form>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm text-green-700 bg-green-50 border border-green-200 rounded-lg px-3 py-2">
                            A new verification link has been sent to your email address.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>Save</x-primary-button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-500">
                    Saved.
                </p>
            @endif
        </div>
    </form>
</section>
