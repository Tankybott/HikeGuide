<x-guest-layout>
    <h2 class="text-xl font-bold text-gray-900 mb-2">Verify your email</h2>
    <p class="text-sm text-gray-500 mb-6">
        Thanks for signing up! Please verify your email by clicking the link we just sent you.
        If you didn't receive it, you can request a new one below.
    </p>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 text-sm text-green-700 bg-green-50 border border-green-200 rounded-lg px-4 py-3">
            A new verification link has been sent to your email address.
        </div>
    @endif

    <div class="flex flex-col gap-3">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button class="w-full justify-center">
                Resend Verification Email
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-sm text-gray-500 hover:text-gray-700 transition-colors">
                Log out
            </button>
        </form>
    </div>
</x-guest-layout>
