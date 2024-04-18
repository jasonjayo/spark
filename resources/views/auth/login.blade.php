<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    @if (session('ban'))
        @php
            $ban = session('ban');
        @endphp
        <div class="alert alert-danger" role="alert">
            <h5>Account Banned</h5>
            @if ($ban->active_to)
                Your account is banned until {{ $ban->active_to }}.
            @else
                Your account is permanently banned.
            @endif
            <br>Reason: {{ $ban->reason }}
            <br>Ban ID: {{ $ban->id }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="form-signin">
        @csrf

        <!-- Email Address -->

        <div class="form-floating mb-3">
            <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" placeholder="Email" />
            <x-input-label for="email" :value="__('Email')" />

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="form-floating">
            <x-text-input id="password" class="form-control" type="password" name="password" required
                autocomplete="current-password" placeholder="Password" />
            <x-input-label for="password" :value="__('Password')" />



            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>


        <!-- Remember Me -->
        <div class="checkbox mt-3 mb-3">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>
        <div class="mt-1">
            <a class="text-muted" href="{{ route('register') }}">
                {{ __('Need to register?') }}
            </a>
        </div>
        <div class="mt-4 items-center">


            <x-primary-button class="btn btn-lg btn-primary btn-block full-w">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
