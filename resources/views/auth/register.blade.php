<x-guest-layout>
    <h2 class="text-xl font-bold text-gray-900 mb-6">Create an account</h2>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="nickname" :value="__('Nickname')" />
            <x-text-input id="nickname" class="mt-1" type="text" name="nickname" :value="old('nickname')" required autofocus autocomplete="nickname" />
            <x-input-error :messages="$errors->get('nickname')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-1" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="mt-1" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="mt-1" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <x-primary-button class="w-full justify-center">
            Register
        </x-primary-button>

        <p class="text-center text-sm text-gray-500">
            Already have an account?
            <a href="{{ route('login') }}" class="text-orange-600 hover:text-orange-700 font-medium transition-colors">Log in</a>
        </p>
    </form>
</x-guest-layout>
