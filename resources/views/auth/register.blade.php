<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('register') }}" class="form-signin">
        @csrf

        <!-- First Name -->
        <div class="form-floating mb-3">
            <x-text-input id="first_name" class="form-control" type="text" name="first_name" :value="old('first_name')"
                required autofocus autocomplete="given-name" placeholder="{{ __('First Name') }}" />
            <x-input-label for="first_name" :value="__('First Name')" />

            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
        </div>

        <!-- Second Name -->
        <div class="form-floating mb-3">
            <x-text-input id="second_name" class="form-control" type="text" name="second_name" :value="old('second_name')"
                required autocomplete="family-name" placeholder="{{ __('Second Name') }}" />
            <x-input-label for="second_name" :value="__('Second Name')" />

            <x-input-error :messages="$errors->get('second_name')" class="mt-2" />
        </div>

        <!-- DOB -->
        <div class="form-floating mb-3">
            <x-text-input id="dob" class="form-control" type="date" name="dob" :value="old('dob')"
                required autocomplete="bday" placeholder="{{ __('Date of Birth') }}" />
            <x-input-label for="dob" :value="__('Date of Birth')" />

            <x-input-error :messages="$errors->get('dob')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="form-floating mb-3">
            <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')"
                required autocomplete="username" placeholder="{{ __('Email') }}" />
            <x-input-label for="email" :value="__('Email')" />

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="form-floating mb-3">
            <x-text-input id="password" class="form-control" type="password" name="password" required
                autocomplete="new-password" placeholder="{{ __('Password') }}" />
            <x-input-label for="password" :value="__('Password')" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="form-floating mb-3">
            <x-text-input id="password_confirmation" class="form-control" type="password"
                name="password_confirmation" required autocomplete="new-password" placeholder="{{ __('Confirm Password') }}" />
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Password Requirements -->
        <div class="mt-2">
            <p class="text-muted">Password must:</p>
            <ul class="text-muted">
                <li>Be at least 8 characters long.</li>
                <li>Contain at least one uppercase letter.</li>
                <li>Contain at least one lowercase letter.</li>
                <li>Contain at least one number.</li>
                <li>Contain at least one symbol or special character.</li>
            </ul>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="text-muted" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
        </div>

        <div class="mt-4 items-center">
            <x-primary-button class="btn btn-lg btn-primary btn-block full-w">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>