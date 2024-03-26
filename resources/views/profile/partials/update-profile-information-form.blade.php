<section>

<?php
$firstToUpper = ucfirst($user->first_name);
$secondToUpper = ucfirst($user->second_name); 
?> 
             
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{__($firstToUpper . "'s " . "Profile Information") }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

<div class="d-flex flex-column ">
<!-- Basic Details Div -->
<div class=""> {{__("Basic Details") }}

        <div> <!-- User Id  -->
            <x-input-label for="user_id" :value="__('User ID')" /> :
            <x-input-label id="user_id" name="user_id" type="text" class="mt-1 block w-full" :value="old('name', $user->id)" required autofocus autocomplete="name" /> 

        </div>

        <div> <!-- First Name Input -->
            <x-input-label for="first_name" :value="__('First Name')" />
            <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full {$gray-500}-bg-subtle" :value="old('name', $firstToUpper)" required autofocus autocomplete="given-name" /> 
            <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
        </div>

        <div> <!-- Second Name Input -->
            <x-input-label for="second_name" :value="__('Second Name')" />
            <x-text-input id="second_name" name="second_name" type="text" class="mt-1 block w-full" :value="old('name', $secondToUpper)" required autofocus autocomplete="family-name" /> 
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>


        <div> <!-- Email Input -->
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="email" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>
            </div>
      


<!--Personal Details -->
<div> Bit more about yourself
<div> <!-- First Name Input -->
            <x-input-label for="gender" :value="__('Gender')" />
          <select class="form-select form-select-sm mb-2" id="gender">
          <option value="">--Please choose an option--</option>
            <option value="F">Female</option>
            <option  value="M">Male</option>
            <option  value="O">Other</option>
            <option value="X">Prefer not to say</option>
            </select>
        </div>
        <div>

            <x-input-label  for="bio" :value="__('Bio')" />
            <textarea name="bio" rows="5" cols="50"/></textarea>
            </div>
            </div>

        <div class="flex items-center gap-4 g">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
            </div>
    </form>
</section>
