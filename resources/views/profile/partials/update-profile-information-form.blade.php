@use('App\Enums\Gender')
@use('App\Enums\InterestedIn')
@use('App\Enums\Seeking')
@use('App\Models\User')

<section>

    <?php
$firstToUpper = ucfirst($user->first_name);
$secondToUpper = ucfirst($user->second_name);
$user = Auth::user();
$hasProfile = isset($user->profile);
if ($hasProfile) {
    $profile = $user->profile;
}

$hasPhotos = DB::table('photos')->where('user_id', '=', auth()->id())->get();
?>


    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __($firstToUpper . "'s " . 'Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    @if (session('status') === 'profile-updated')
    @if($hasPhotos->isEmpty())
    <div class="alert alert-success" role="alert">
            Profile saved! Why not upload some pictures to your profile in the Update Photos section!
        </div>
        @else 
        <div class="alert alert-success" role="alert">
            Profile saved! 
        </div>
        @endif

    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form method="post" action="{{ route('profile.store') }}" class="mt-6 space-y-6">
        @csrf

        @if (!$hasProfile)
            <div class="alert alert-primary" role="alert">
                <b>You haven't created your profile yet. Fill out your details below to get full access to Spark.</b>
            </div>
        @endif



        <form method="post" action="{{ route('profile.store') }}" class="mt-6 space-y-6">
            @csrf

            <div class="container d-flex flex-column ">
                <!-- Basic Details Div -->
                <div class="mb-3">
                    <h2>Basic Details</h2>
                    <p>These details cannot be changed.</p>

                    <div class="form-floating mb-3"> <!-- User Id  -->
                        <input id="user_id" name="id" type="text" class="form-control mt-1 block w-full"
                            value="{{ old('id', $user->id) }}" required autofocus autocomplete="name" readonly />
                        <label for="user_id">User ID </label>


                    </div>

                    <div class="form-floating mb-3"> <!-- First Name Input -->

                        <input id="first_name" name="first_name" type="text"
                            class="form-control mt-1 block {$gray-500}-bg-subtle"
                            value="{{ old('first_name', $firstToUpper) }}" required autofocus autocomplete="given-name"
                            readonly />
                        <label for="first_name">First Name</label>
                        <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
                    </div>

                    <div class="form-floating mb-3"> <!-- Second Name Input -->
                        <input id="second_name" name="second_name" type="text" class="form-control mt-1 block w-full"
                            value="{{ old('second_name', $secondToUpper) }}" required autofocus
                            autocomplete="family-name" readonly />
                        <label for="second_name">Second Name </label>
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>
                </div>



                <!--Personal Details -->
                <div class="mb-3">
                    <h2>A Bit More About Yourself</h2>
                    <div class="form-floating mb-3">
                        <!-- Gender Input -->
                        <select name="gender" class="form-select mb-2" id="gender">
                            @foreach (Gender::cases() as $gender)
                                <option value="{{ $gender->value }}"
                                    {{ $gender->value == old('gender', $hasProfile ? $profile->gender->value : 'o') ? 'selected' : '' }}>
                                    {{ $gender->getLabel() }}</option>
                            @endforeach
                        </select>
                        <label for="gender">Gender</label>
                    </div>
                    <div class="form-floating mb-3">
                        <!-- Bio -->
                        <textarea class="form-control" name="bio" style="height:100px" cols="50" maxlength="1000"
                            placeholder="Describe yourself here...">{{ old('bio', $hasProfile ? $profile->bio : '') }}</textarea>
                        <label for="bio">Bio<label />
                    </div>

                    <div class="form-floating mb-3">
                        <!-- Tagline -->
                        <input id="tagline" name="tagline" type="text" class="form-control" size="50"
                            placeholder="I am a coffee lover!" maxlength="50"
                            value="{{ old('tagline', $hasProfile ? $profile->tagline : '') }}" />
                        <label for="tagline">Tagline</label>

                    </div>

                    <div class="form-floating mb-3">
                        <!-- Interested In -->
                        <select name="interested_in" class="form-select mb-2" id="interested_in">
                            @foreach (InterestedIn::cases() as $interested_in_option)
                                <option value="{{ $interested_in_option->name }}"
                                    {{ $interested_in_option->name == old('interested_in', $hasProfile ? $profile->interested_in->name : 'ALL') ? 'selected' : '' }}>
                                    {{ $interested_in_option->getLabel() }}</option>
                            @endforeach
                        </select>
                        <label for="interested_in">Interested In</label>
                    </div>

                    <div class="form-floating mb-3">
                        <!-- Seeking -->
                        <select name="seeking" class="form-select" id="seeking">
                            @foreach (Seeking::cases() as $seeking_option)
                                <option value="{{ $seeking_option->name }}"
                                    {{ $seeking_option->name == old('seeking', $hasProfile ? $profile->seeking->name : 'UNKNOWN') ? 'selected' : '' }}>
                                    {{ $seeking_option->getLabel() }}
                                </option>
                            @endforeach
                        </select>
                        <label for="seeking">Length of relationship you're seeking</label>
                    </div>

                    <div class="form-floating mb-3">
                        <!-- University -->
                        <input name="university" type="text" class="form-control" id="floatingInput"
                            placeholder="University of Limerick" size="50" maxlength="50"
                            value="{{ old('university', $hasProfile ? $profile->university : '') }}">
                        <label for="floatingInput">University </label>

                    </div>

                    <div class="form-floating mb-3">
                        <!-- Work -->
                        <input id="work" name="work" type="text" class="form-control" size="50"
                            placeholder="Barista" maxlength="50"
                            value="{{ old('work', $hasProfile ? $profile->work : '') }}" />
                        <label for="work">Profession</label>

                    </div>
                    <!-- make the input box for this smaller so i can put the button beside it  -->
                    <p>Location will be set automatically by your browser, if you've <a target="_blank"
                            href="https://docs.buddypunch.com/en/articles/919258-how-to-enable-location-services-for-chrome-safari-edge-and-android-ios-devices-gps-setting">given
                            permission</a>.</p>
                    <div class="form-floating mb-3">
                        <!-- Location -->
                        <input id="location" name="location" type="text" class="form-control" size=20
                            maxlength=40 pattern="(-)?\d+(\.\d+)?,\s?(-)?\d+(\.\d+)?" readonly
                            value="{{ old('location', $hasProfile ? $profile->location : '') }}" />
                        <label for="location">Location</label>
                    </div>

                </div>


                <div class="">
                    <h2>Extra Bits</h2>
                    <p>These fields are optional.</p>
                    <div class="form-floating mb-3">
                        <!-- Favoutite Movie -->
                        <input id="fav_movie" name="fav_movie" type="text" class="form-control" maxlength=50
                            value="{{ old('fav_movie', $hasProfile ? $profile->fav_movie : '') }}"
                            placeholder="seven" />
                        <label for="fav_movie">Favourite Movie</label>
                    </div>

                    <div class="form-floating mb-3">
                        <!-- Favoutite Food -->
                        <input id="fav_food" name="fav_food" type="text" class="form-control" size=50
                            placeholder="Pizza" maxlength=50
                            value="{{ old('fav_food', $hasProfile ? $profile->fav_food : '') }}">
                        <label for="fav_food">Favourite Food</label>
                    </div>

                    <div class="form-floating mb-3">
                        <!-- Favoutite Song -->
                        <input id="fav_song" name="fav_song" type="text" class="form-control" size=50
                            placeholder="Everything She Wants" maxlength=50
                            value="{{ old('fav_song', $hasProfile ? $profile->fav_song : '') }}">
                        <label for="fav_song">Favourite Song</label>
                    </div>

                    <div class="form-floating mb-3">
                        <!-- Personality Type -->
                        <input id="personality_type" name="personality_type" type="text" placeholder="ISFJ"
                            class="form-control" size=4 maxlength=4
                            value="{{ old('personality_type', $hasProfile ? $profile->personality_type : '') }}"  pattern="[A-Za-z]{4}" />
                        <label for="personality_type">Myers Briggs Personality Type (e.g. INTP)</label>
                    </div>
                    <div class="form-floating mb-3">
                        <!-- Height -->
                        <input id="height" name="height" type="text" class="form-control" size=4
                            placeholder="1.75m" maxlength=4 pattern="^[0-9](\.[0-9]{0,2})?$"
                            value="{{ old('height', $hasProfile ? $profile->height : '') }}" />
                        <label for="height">Height in Meters (e.g., 1.53)</label>
                    </div>
                    <div class="form-floating mb-3">
                        <!-- Languages -->
                        <input id="languages" name="languages" type="text" class="form-control" size=50
                            placeholder="Gaeilge, English" maxlength=50
                            value="{{ old('languages', $hasProfile ? $profile->languages : '') }}" />
                        <label for="languages">Languages Spoken</label>
                    </div>
                </div>


                <div class="flex items-center gap-4 g">
                    <x-primary-button class="btn btn-primary" name="profile">{{ __('Save') }}</x-primary-button>
                </div>

            </div>
        </form>
</section>
