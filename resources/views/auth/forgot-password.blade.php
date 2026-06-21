<x-guest-layout>
    <h2 class="text-xl font-bold text-gray-900 mb-2">Forgot your password?</h2>
    <p class="text-sm text-gray-500 mb-6">Enter your email and we'll send you a reset link.</p>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-1" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <x-primary-button class="w-full justify-center">
            Send Reset Link
        </x-primary-button>

        <p class="text-center text-sm text-gray-500">
            <a href="{{ route('login') }}" class="text-orange-600 hover:text-orange-700 font-medium transition-colors">Back to login</a>
        </p>
    </form>
</x-guest-layout>
