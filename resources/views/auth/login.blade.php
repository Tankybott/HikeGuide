<x-guest-layout>
    <h2 class="text-xl font-bold text-gray-900 mb-6">Sign in to your account</h2>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-1" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="mt-1" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center gap-2 text-sm text-gray-600">
                <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-orange-500 focus:ring-orange-500">
                Remember me
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-orange-600 hover:text-orange-700 transition-colors">
                    Forgot password?
                </a>
            @endif
        </div>

        <x-primary-button class="w-full justify-center">
            Log in
        </x-primary-button>

        <p class="text-center text-sm text-gray-500">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-orange-600 hover:text-orange-700 font-medium transition-colors">Register</a>
        </p>
    </form>
</x-guest-layout>
