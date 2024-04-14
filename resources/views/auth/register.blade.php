<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="col-12 pass-forget">
        @csrf

        <!-- First Name -->
        <div class="form-label-group">
            <x-input-label for="first_name" :value="__('First Name')" />
            <x-text-input id="first_name" class="form-control" type="text" name="first_name" :value="old('first_name')"
                required autofocus autocomplete="given-name" />
            <x-input-error :messages="$errors->get('first_name')" class="mt-2 overflow-scroll error" />
        </div>

        <!-- Second Name -->
        <div class="form-label-group mt-4">
            <x-input-label for="second_name" :value="__('Second Name')" />
            <x-text-input id="second_name" class="form-control" type="text" name="second_name" :value="old('second_name')"
                required autocomplete="family-name" />
            <x-input-error :messages="$errors->get('second_name')" class="mt-2 overflow-scroll error" />
        </div>

        <!-- DOB -->
        <div class="form-label-group mt-4">
            <x-input-label for="dob" :value="__('Date of Birth')" />
            <x-text-input id="dob" class="form-control" type="date" name="dob" :value="old('dob')"
                required autocomplete="bday" />
            <x-input-error :messages="$errors->get('dob')" class="mt-2 overflow-scroll error" />
        </div class="form-label-group">

        <!-- Email Address -->
        <div class="form-label-group mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 overflow-scroll error" />
        </div>

        <!-- Password -->
        <div class="form-label-group mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="form-control" type="password" name="password" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2 overflow-scroll  error" />
        </div>

        <!-- Confirm Password -->
        <div class="form-label-group mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="form-control" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 overflow-scroll error" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="text-muted"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            
        </div>
        <x-primary-button class="btn btn-primary mt-2">
                {{ __('Register') }}
            </x-primary-button>
    </form>
</x-guest-layout>
