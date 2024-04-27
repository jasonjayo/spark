@use('App\Enums\Gender')
@use('App\Enums\InterestedIn')
@use('App\Enums\Seeking')
@use('App\Models\User')
@use('App\Models\Interest')
@use('App\Models\SparkTrait')

<section>
    <style>
        .ba {
            border-style: solid;
            border-width: 1px;
        }

        .br-pill {
            border-radius: 9999px;
        }

        .bw1 {
            border-width: .125rem;
        }

        .bw2 {
            border-width: .25rem;
        }

        .dib {
            display: inline-block;
        }

        .fw6 {
            font-weight: 600;
        }

        .tracked {
            letter-spacing: .1em;
        }

        .link {
            text-decoration: none;
            transition: color .15s ease-in;
        }

        /* .link:link, .link:visited {
    transition: color .15s ease-in;
} */



        .pv2 {
            padding-top: .5rem;
            padding-bottom: .5rem;
        }

        .ph3 {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .mb2 {
            margin-bottom: .5rem;
        }

        .mb4 {
            margin-bottom: 2rem;
        }

        .mt4 {
            margin-top: 2rem;
        }


        .f6 {
            font-size: .875rem;
        }

        .dim {
            opacity: 1;
            transition: opacity .15s ease-in;
        }

        .dim:hover,
        .dim:focus {
            opacity: .5;
            transition: opacity .15s ease-in;
        }

        /* .dim:active {
    opacity: .8;
    transition: opacity .15s ease-out;
} */
        .intr_color {
            border-color: var(--spk-color-primary-1);
            color: var(--spk-color-primary-1);
        }

        .traits_color {
            border-color: var(--spk-color-secondary-1);
            color: var(--spk-color-secondary-1);
        }

        .on {
            opacity: 0.5;
            outline-style: solid;
            outline-width: 2px;
            outline-color: var(--spk-color-primary-1);
            transition: outline .02s linear;
            transition: opacity .15s ease-in-out;
        }
    </style>


    <?php
    $firstToUpper = ucfirst($user->first_name);
    $secondToUpper = ucfirst($user->second_name);
    $hasProfile = isset($user->profile);
    if ($hasProfile) {
        $profile = $user->profile;
    }
    
    $hasPhotos = DB::table('photos')->where('user_id', '=', auth()->id())->get();
    $userinterests = DB::table('interest_user')->where('user_id', '=', auth()->id())->get();
    $usertraits = DB::table('trait_user')->where('user_id', '=', auth()->id())->get();
    $hasInterests = false;
    $hasTraits = false;
    ?>
    <script>
        var interestActive = false;
        var traitActive = false;
        var selectedInterests = [];
        var selectedTraits = [];
    </script>


    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">Interests and Traits</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6 class="modal-title" id="exampleModalLabel"> Hey There! Care to tell us about some of your
                        interests and traits?</h6>
                    <div class="ph3 mt4">
                        <h1 class="f6 fw6 ttu tracked">Interests</h1>
                        @foreach (Interest::get() as $interest)
                            <button id="test" class="f6 link dim br-pill ba ph3 pv2 mb2 dib intr_color"
                                href="#0" data-interest-name="{{ $interest->name }}"
                                data-interest-id=" {{ $interest->id }}" data-interest-category="testCat"
                                onclick="addSelectedInterest(this)">
                                {{ $interest->name }}
                            </button>
                        @endforeach
                    </div>
                    <div class="ph3 mt4">
                        <h1 class="f6 fw6 ttu tracked">Traits</h1>
                        @foreach (SparkTrait::get() as $trait)
                            <button class="f6 link dim br-pill ba ph3 pv2 mb2 dib  traits_color" href="#0"
                                data-trait-name="{{ $trait->name }}" data-trait-id=" {{ $trait->id }}"
                                data-trait-category="testCat" onclick="addSelectedTrait(this)">
                                {{ $trait->name }}
                            </button>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form action="{{ route('profile.addUserInterestsAndTraits') }}" method="POST">
                        @csrf

                        <input type="text" class="interestInput" value="" name="interests" id="interests" />
                        <input type="hidden" class="traitInput" value="" name="traits" id="traits" />

                        <button type="submit" class="btn btn-primary" data-dismiss="modal">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __($firstToUpper . "'s " . 'Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information.") }}
        </p>
        <div>

        </div>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <!-- Modal -->
    @if (session('status') === 'interestsAndTraits-created')
        <div class="alert alert-success" role="alert">
            Your chosen interests and traits have been saved!!
        </div>
    @endif

    @if (session('status') === 'profile-updated')
        @if ($hasPhotos->isEmpty())
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

            <input type="text" value="{{ $user->id }}" hidden>

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
                            value="{{ old('first_name', $firstToUpper) }}" required readonly />
                        <label for="first_name">First Name</label>
                        <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
                    </div>

                    <div class="form-floating mb-3"> <!-- Second Name Input -->
                        <input id="second_name" name="second_name" type="text" class="form-control mt-1 block w-full"
                            value="{{ old('second_name', $secondToUpper) }}" required readonly />
                        <label for="second_name">Second Name </label>
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div class="form-floating mb-3"> <!-- DOB -->
                        <input id="dob" name="dob" type="date" class="form-control mt-1 block w-full"
                            value="{{ $user->dob }}" required readonly />
                        <label for="second_name">Date of Birth </label>
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
                        <label for="bio">Write a bio about yourself here...<label />
                    </div>

                    <div class="form-floating mb-3">
                        <!-- Tagline -->
                        <input id="tagline" name="tagline" type="text" class="form-control" size="50"
                            placeholder="I am a coffee lover!" maxlength="50"
                            value="{{ old('tagline', $hasProfile ? $profile->tagline : '') }}" />
                        <label for="tagline">First thing you'd say when you meet someone new?</label>

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
                        <label for="floatingInput">Where do you study?</label>

                    </div>

                    <div class="form-floating mb-3">
                        <!-- Work -->
                        <input id="work" name="work" type="text" class="form-control" size="50"
                            placeholder="Barista" maxlength="50"
                            value="{{ old('work', $hasProfile ? $profile->work : '') }}" />
                        <label for="work">What do you work as?</label>

                    </div>
                    <!-- make the input box for this smaller so i can put the button beside it  -->
                    <p>Location will be set automatically by your browser, if you've <a target="_blank"
                            href="https://docs.buddypunch.com/en/articles/919258-how-to-enable-location-services-for-chrome-safari-edge-and-android-ios-devices-gps-setting">given
                            permission</a>.</p>
                    {{-- <div class="form-floating mb-3">
                        <!-- Location -->
                        <input id="location" name="location" type="text" class="form-control" size=20
                            maxlength=40 pattern="(-)?\d+(\.\d+)?,\s?(-)?\d+(\.\d+)?" readonly
                            value="{{ old('location', $hasProfile ? $profile->location : '') }}" />
                        <label for="location">Location</label>
                    </div> --}}

                </div>


                <div class="">
                    <h2>Extra Bits</h2>
                    <p>These fields are optional.</p>
                    <div class="form-floating mb-3">
                        <!-- Favoutite Movie -->
                        <input id="fav_movie" name="fav_movie" type="text" class="form-control" maxlength=50
                            value="{{ old('fav_movie', $hasProfile ? $profile->fav_movie : '') }}"
                            placeholder="seven" />
                        <label for="fav_movie">Your top choice for a movie to watch?</label>
                    </div>

                    <div class="form-floating mb-3">
                        <!-- Favoutite Food -->
                        <input id="fav_food" name="fav_food" type="text" class="form-control" size=50
                            placeholder="Pizza" maxlength=50
                            value="{{ old('fav_food', $hasProfile ? $profile->fav_food : '') }}">
                        <label for="fav_food">One dish that you could eat for the rest of your life?</label>
                    </div>

                    <div class="form-floating mb-3">
                        <!-- Favoutite Song -->
                        <input id="fav_song" name="fav_song" type="text" class="form-control" size=50
                            placeholder="Everything She Wants" maxlength=50
                            value="{{ old('fav_song', $hasProfile ? $profile->fav_song : '') }}">
                        <label for="fav_song">What is your all-time favourite song?</label>
                    </div>

                    <div class="form-floating mb-3">
                        <!-- Personality Type -->
                        <input id="personality_type" name="personality_type" type="text" placeholder="ISFJ"
                            class="form-control" size=4 maxlength=4
                            value="{{ old('personality_type', $hasProfile ? $profile->personality_type : '') }}"
                            pattern="[A-Za-z]{4}" />
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
                        <label for="languages">Do you speak any lanuages?</label>
                    </div>
                </div>

                <div class="flex items-center gap-4 g">
                    <button class="btn btn-primary" name="profile">Save Profile</button>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">
                        Interests and Traits
                    </button>
                </div>
            </div>

            <script>
                function addSelectedInterest(e) {
                    var interestId = e.getAttribute("data-interest-id");
                    if (!selectedInterests.includes(interestId)) {
                        selectedInterests.push(interestId);
                        var interestInput = document.querySelector("#interests");
                        interestInput.value = selectedInterests.toString();
                        e.classList.add("on");
                    } else {
                        e.classList.remove("on");
                        var removeIndex = selectedInterests.indexOf(interestId);
                        newInput = selectedInterests.splice(removeIndex, 1);
                        console.log(selectedInterests);

                    }
                }
            </script>
            <script>
                function addSelectedTrait(e) {
                    traitsActive = !traitsActive;
                    if (traitsActive == true) {
                        var traitId = e.getAttribute("data-trait-id");
                        var traitInput = document.querySelector('#traits');
                        traitInput.value += traitId + ",";
                    }
                }
            </script>
        </form>
</section>
