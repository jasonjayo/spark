<x-guest-layout>
    <div class="pass-forget">
    <div class="mb-4 text-sm text-muted container text-center">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" class="form-signin form bg-gray-100" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="form-label-group m-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end m-4">
            <x-primary-button class="btn btn-primary">
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</div>
</x-guest-layout>
