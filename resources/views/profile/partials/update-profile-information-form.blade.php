@use('App\Enums\Gender')
@use('App\Enums\InterestedIn')
@use('App\Enums\Seeking')

<section>

    <?php
$firstToUpper = ucfirst($user->first_name);
$secondToUpper = ucfirst($user->second_name);
$user = Auth::user();
$hasProfile = isset($user->profile);
if ($hasProfile) {
    $profile = $user->profile;
}
    ?>

    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __($firstToUpper . "'s " . 'Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>


    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    @if (session('status') === 'profile-updated')
        <div class="alert alert-success" role="alert">
            Profile saved!
        </div>
    @endif
    <form method="post" action="{{ route('profile.store') }}" class="mt-6 space-y-6">
        @csrf

    @if (!$hasProfile)
        <div class="alert alert-primary" role="alert">
            <b>You haven't created your profile yet. Fill out your details below to get full access to Spark.</b>
        </div>
    @endif

    


        <div class="d-flex flex-column ">
            <!-- Basic Details Div -->
            <div class=""> {{ __('Basic Details') }}

                <div> <!-- User Id  -->
                    <x-input-label for="user_id" :value="__('User ID')" /> :
                    <x-input-label id="user_id" name="id" type="text" class="mt-1 block w-full"
                        :value="old('id', $user->id)" required autofocus autocomplete="name" />

                </div>

                <div> <!-- First Name Input -->
                    <x-input-label for="first_name" :value="__('First Name')" />
                    <x-text-input id="first_name" name="first_name" type="text"
                        class="mt-1 block w-full {$gray-500}-bg-subtle" :value="old('first_name', $firstToUpper)" required autofocus
                        autocomplete="given-name" />
                    <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
                </div>

                <div> <!-- Second Name Input -->
                    <x-input-label for="second_name" :value="__('Second Name')" />
                    <x-text-input id="second_name" name="second_name" type="text" class="mt-1 block w-full"
                        :value="old('second_name', $secondToUpper)" required autofocus autocomplete="family-name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>
            </div>



            <!--Personal Details -->
            <div> Bit more about yourself
                <div>
                    <!-- Gender Input -->
                    <x-input-label for="gender" :value="__('Gender')" />
                    <select name="gender" class="form-select form-select-sm mb-2" id="gender">

                        @foreach (Gender::cases() as $gender)
                            <option value="{{ $gender->value }}"
                                {{ $gender->value == old('gender', $hasProfile ? $profile->gender->value : 'o') ? 'selected' : '' }}>
                                {{ $gender->getLabel() }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <!-- Bio -->
                    <x-input-label for="bio" :value="__('Bio')" />
                    <textarea name="bio" rows="5" cols="50" maxlength="1000">{{ old('gender', $hasProfile ? $profile->bio : '') }}</textarea>
                </div>

                <div>
                    <!-- Tagline -->
                    <x-input-label for="tagline" :value="__('Tagline')" />
                    <x-text-input id="tagline" name="tagline" type="text" class="mt-1 block w-full" size="50"
                        maxlength="50" value="{{ old('tagline', $hasProfile ? $profile->tagline : '') }}" />
                </div>

                <div>
                    <!-- Interested In -->
                    <x-input-label for="interested_in" :value="__('Interested In')" />
                    <select name="interested_in" class="form-select form-select-sm mb-2" id="interested_in">
                        @foreach (InterestedIn::cases() as $interested_in_option)
                            <option value="{{ $interested_in_option->name }}"
                                {{ $interested_in_option->name == old('interested_in', $hasProfile ? $profile->interested_in : 'ALL') ? 'selected' : '' }}>
                                {{ $interested_in_option->getLabel() }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <!-- Seeking -->
                    <x-input-label for="seeking" :value="__('Length of relationship you are seeking?')" />
                    <select name="seeking" class="form-select form-select-sm mb-2" id="seeking">
                        @foreach (Seeking::cases() as $seeking_option)
                            <option value="{{ $seeking_option->name }}"
                                {{ $seeking_option->name == old('seeking', $hasProfile ? $profile->seeking : 'UNKNOWN') ? 'selected' : '' }}>
                                {{ $seeking_option->getLabel() }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <!-- University -->
                    <x-input-label for="university" :value="__('University')" />
                    <x-text-input id="uni" name="university" type="text" class="mt-1 block w-full"
                        size="50" maxlength="50"
                        value="{{ old('university', $hasProfile ? $profile->university : '') }}" />
                </div>

                <div>
                    <!-- Work -->
                    <x-input-label for="work" :value="__('Profession/Work')" />
                    <x-text-input id="work" name="work" type="text" class="mt-1 block w-full" size="50"
                        maxlength="50" value="{{ old('work', $hasProfile ? $profile->work : '') }}" />
                </div>

                <div>
                    <!-- Location -->
                    <x-input-label for="location" :value="__('Location')" />
                    <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" size=20
                        maxlength=20 value="{{ old('location', $hasProfile ? $profile->location : '') }}" />
                    <button id="update-location">Update location</button>
                </div>

            </div>


            <div>Extra bits
                <div>
                    <!-- Favoutite Movie -->
                    <x-input-label for="fav_movie" :value="__('Favourite Movie')" />
                    <x-text-input id="fav_movie" name="fav_movie" type="text" class="mt-1 block w-full" size=50
                        maxlength=50 value="{{ old('fav_movie', $hasProfile ? $profile->fav_movie : '') }}" />
                </div>

                <div>
                    <!-- Favoutite Food -->
                    <x-input-label for="fav_food" :value="__('Favourite Food')" />
                    <x-text-input id="fav_food" name="fav_food" type="text" class="mt-1 block w-full" size=50
                        maxlength=50 value="{{ old('fav_food', $hasProfile ? $profile->fav_food : '') }}" />
                </div>

                <div>
                    <!-- Favoutite Song -->
                    <x-input-label for="fav_song" :value="__('Favourite Song')" />
                    <x-text-input id="fav_song" name="fav_song" type="text" class="mt-1 block w-full" size=50
                        maxlength=50 value="{{ old('fav_song', $hasProfile ? $profile->fav_song : '') }}" />
                </div>

                <div>
                    <!-- Personality Type -->
                    <x-input-label for="personality_type" :value="__('Personality Type (Myers-Briggs)')" />
                    <x-text-input id="personality_type" name="personality_type" type="text"
                        class="mt-1 block w-full" size=4 maxlength=4
                        value="{{ old('personality_type', $hasProfile ? $profile->personality_type : '') }}" />
                </div>
                <div>
                    <!-- Height -->
                    <x-input-label for="height" :value="__('Height in Metres (e.g 1.63cm)')" />
                    <x-text-input id="height" name="height" type="text" class="mt-1 block w-full" size=4
                        maxlength=4 value="{{ old('height', $hasProfile ? $profile->height : '') }}" />
                </div>
                <div>
                    <!-- Languages -->
                    <x-input-label for="languages" :value="__('Languages Spoken')" />
                    <x-text-input id="languages" name="languages" type="text" class="mt-1 block w-full" size=50
                        maxlength=50 value="{{ old('languages', $hasProfile ? $profile->languages : '') }}" />
                </div>
            </div>


            <div class="flex items-center gap-4 g">
                <x-primary-button>{{ __('Save') }}</x-primary-button>
            </div>

            <script>
                document.querySelector("#update-location").addEventListener("click", (e) => {
                    e.preventDefault();
                    navigator.geolocation.getCurrentPosition((pos) => {
                        document.querySelector("#location").value =
                            `${pos.coords.latitude}, ${pos.coords.longitude}`;
                    });
                })
            </script>
        </div>
    </form>
</section>
