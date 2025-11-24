<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('This is a secure area. Please enter the verification code sent to your email.') }}
    </div>

    @if (session('message'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('message') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 font-medium text-sm text-red-600">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('verify.store') }}">
        @csrf

        <div>
            <label class="block font-medium text-sm text-gray-700">Verification Code</label>
            <input class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="text" name="two_factor_code" required autofocus />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a href="{{ route('verify.resend') }}" class="underline text-sm text-gray-600 hover:text-gray-900 mr-4">
                Resend Code
            </a>

            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-gray-700">
                Verify
            </button>
        </div>
    </form>
</x-guest-layout>