@props(['profile'])
@use ('App\Models\Photo')
@use ('App\Models\AIResponse')
@use ('App\Models\SparkMatch')


@pushOnce('scripts')
    @vite(['resources/js/viewprofile.js', 'resources/css/viewprofile.css'])
@endPushOnce

<x-app-layout>
    <x-slot:title>{{ $profile->user->first_name }}'s profile</x-slot>

    <?php
    $my = Auth::user();
    $first_user_id = min($my->id, $profile->user->id);
    $second_user_id = max($my->id, $profile->user->id);
    $date_ideas = AIResponse::where('user_1_id', $first_user_id)->where('user_2_id', $second_user_id)->first();
    
    $match = SparkMatch::where(['user_1_id' => $first_user_id, 'user_2_id' => $second_user_id])->first();
    ?>
    <div id="loader"
        class="d-none flex-column justify-content-center align-items-center position-fixed start-0 top-0 bottom-0 end-0 z-2">
        <div id="loader-background" class="position-absolute start-0 top-0 bottom-0 end-0">
        </div>
        <div class="spinner-border text-light z-3" style="width: 5rem; height: 5rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="mt-4 text-white z-3 fs-5">
            <b>Generating your personalised date ideas...</b>
        </div>
    </div>

    @if (Auth::user()->isAdmin())
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Ban User') }}</div>

                        <div class="card-body">
                            <form action="{{ route('ban.create') }}" method="POST" x-data="{ banType: '' }">
                                @csrf
                                <input type="number" name="user_id" hidden value="{{ $profile->user->id }}">

                                <div class="mb-3">
                                    <label for="reason" class="form-label">{{ __('Reason') }}</label>
                                    <input type="text" id="reason" name="reason" class="form-control"
                                        placeholder="{{ __('Enter reason') }}" value="You got banned.">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">{{ __('Ban Type') }}</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="banType" id="permanentBan"
                                            value="permanent" x-model="banType">
                                        <label class="form-check-label"
                                            for="permanentBan">{{ __('Permanent Ban') }}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="banType" id="timeout"
                                            value="timeout" x-model="banType">
                                        <label class="form-check-label" for="timeout">{{ __('Timeout') }}</label>
                                    </div>
                                </div>

                                <div class="mb-3" x-show="banType === 'timeout'">
                                    <label for="expiry" class="form-label">{{ __('Ban Expiry') }}</label>
                                    <input name="expiry" id="expiry" type="date" class="form-control">
                                </div>

                                <button type="submit" class="btn btn-primary">{{ __('Ban') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Account</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this user's account?<br>This action cannot be undone.
                        <form id="deleteUserForm" method="POST" action="{{ route('deleteUserAccount') }}">
                            @csrf
                            @method('delete')
                            <input type="text" name="id" hidden value="{{ $profile->user->id }}">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button id="deleteAccountConfirm" type="button" class="btn btn-primary">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="container profile-container">
        @if (session('match'))
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-success fs-4" role="alert">
                        <b class="me-3">🎉 It's a match! </b>
                        You can now chat with {{ $profile->user->first_name }}.
                    </div>
                </div>
            </div>
        @endif

        {{-- sent from AdminController --}}
        @if (session('report_id'))
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-success" role="alert">
                        You have successfully reported {{ $profile->user->first_name }}.
                    </div>
                </div>
            </div>
        @endif

        @if (session('ban_id'))
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-success" role="alert">
                        Ban created successfully (Ban ID: {{ session('ban_id') }})
                    </div>
                </div>
            </div>
        @endif

        @if (session('generation_error'))
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-danger" role="alert">
                        Couldn't generate suggestions, please try again in a few minutes.
                    </div>
                </div>
            </div>
        @endif

        <section class="mt-6 space-y-6">
            <div class="card profile-card position-relative">
                <div class="position-absolute top-0 end-0 p-3">
                    <button type="button" class="btn btn-lg btn-primary bg-transparent" data-bs-toggle="modal"
                        data-bs-target="#reportModal">
                        <span class="material-symbols-outlined text-danger" style="font-size: 40px;">flag</span>
                    </button>
                </div>

                <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="ban-modal-header modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                                <div class="ban-modal-title-container modal-title-container">
                                    <h5 class="modal-title" id="reportModalLabel">Report</h5>
                                    <p class="ban-modal-subtitle modal-subtitle">Don't worry,
                                        {{ $profile->user->first_name }} won't
                                        find out.</p>
                                </div>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('report.create') }}" method="POST" id="reportForm">
                                    @csrf
                                    <form action="{{ route('report.create') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="reported_id" value="{{ $profile->user->id }}">
                                        <div class="mb-3">
                                            <div class="d-grid gap-2">
                                                <button type="submit" class="btn btn-report" name="reason"
                                                    value="Inappropriate Messages">Inappropriate Messages</button>
                                                <button type="submit" class="btn btn-report" name="reason"
                                                    value="Inappropriate Photos">Inappropriate Photos</button>
                                                <button type="submit" class="btn btn-report" name="reason"
                                                    value="Spam">Feels like Spam</button>
                                                <button type="button" class="btn btn-report"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#otherReasonField">Other</button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="collapse" id="otherReasonField">
                                        <form action="{{ route('report.create') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="reported_id"
                                                value="{{ $profile->user->id }}">
                                            <div class="mb-3">
                                                <textarea class="form-control" id="otherReason" name="reason" rows="3" placeholder="Enter reason"></textarea>
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary">Submit
                                                    Report</button>
                                            </div>
                                        </form>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-0">
                    <div class="col-lg-4 col-md-12 mb-3 mb-lg-0">
                        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach ($profile->user->photos as $index => $photo)
                                    <?php
                                    if ($index == 0) {
                                        $activeClass = 'carousel-item active';
                                    } elseif ($index > 0) {
                                        $activeClass = 'carousel-item';
                                    }
                                    ?>
                                    <div class="{{ $activeClass }}">
                                        <img src="{{ asset('images/profilePhotos/' . $photo->photo_url) }}"
                                            class="d-block w-100" alt="{{ $photo->photo_url }}" width=424px
                                            height=445px style="object-fit: cover;">
                                    </div>
                                @endforeach

                            </div>
                            <button class="carousel-control-prev" type="button"
                                data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button"
                                data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-12">
                        <div class="card-body">
                            <div class="profile-info">
                                <div class="d-flex align-items-center">
                                    <h2 class="profile-name">{{ $profile->user->first_name }},
                                        {{ $profile->getAge() }}</h2>
                                </div>
                                @if ($match)
                                    <div class="d-flex">
                                        <span>Matched on {{ date_create($match->created)->format('d/m/Y') }}</span>
                                        <form action="{{ route('deleteMatch') }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <input type="text" name="id" hidden
                                                value="{{ $profile->user->id }}">
                                            <input class="ms-2 p-0 border-0 text-decoration-underline unmatch-btn"
                                                type="submit" value="Unmatch">
                                        </form>
                                    </div>
                                @endif
                                <div>
                                    <div class="profile-tagline">{{ $profile->tagline }}</div>
                                </div>
                                <div class="d-flex gap-2 mb-4">
                                    @if (
                                        !$match &&
                                            $profile->user_id != Auth::user()->id &&
                                            !Auth::user()->isAdmin() &&
                                            !Auth::user()->reactionsSent->pluck('id')->contains($profile->user_id))
                                        <form action="{{ route('react') }}" method="POST" class="m-0">
                                            @csrf
                                            <input hidden type="text" name="id"
                                                value="{{ $profile->user->id }}">
                                            <input hidden type="text" name="type" value="LIKE">
                                            <button type="submit" class="btn btn-primary text-uppercase">
                                                <b>Like</b>
                                            </button>
                                        </form>
                                    @endif
                                    @if ($match)
                                        <a class="btn btn-primary"$
                                            href="{{ route('chat.show', $profile->user->id) }}">
                                            Say Hi!
                                        </a>
                                    @endif
                                    @if ($match && !$date_ideas)
                                        <a class="btn btn-secondary" id="generateAISuggestionsBtn"
                                            href="{{ route('aiSuggestions', $profile->user->id) }}">✨
                                            Generate Date Ideas
                                        </a>
                                    @endif
                                    @if (Auth::user()->isAdmin())
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal">
                                            Delete
                                        </button>
                                        <a class="btn btn-secondary"
                                            href="{{ route('updateUserAccount', ['id' => $profile->user->id]) }}">
                                            Edit
                                        </a>
                                    @endif
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="profile-info">
                                            <div class="profile-location">
                                                <span class="material-symbols-outlined">location_on</span>
                                                <span class="distance">{{ $profile->getDistance() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="profile-info">
                                            <div class="profile-languages">
                                                <span class="material-symbols-outlined">language</span>
                                                {{ $profile->languages ?? 'Languages not provided' }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="profile-info">
                                            <div class="profile-work">
                                                <span class="material-symbols-outlined">work</span>
                                                {{ $profile->work ?? 'Work not specified' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="profile-info">
                                            <div class="profile-university">
                                                <span class="material-symbols-outlined">school</span>
                                                {{ $profile->university ?? 'University not specified' }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="profile-info">
                                            <div class="profile-personality">
                                                <span class="material-symbols-outlined">psychology_alt</span>
                                                @if ($profile->personality_type)
                                                    <span class="text-uppercase">
                                                        {{ $profile->personality_type }}
                                                    </span>
                                                @else
                                                    Personality type not provided
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="profile-info">
                                            <div class="profile-height">
                                                <span class="material-symbols-outlined">height</span>
                                                <span
                                                    class="height-value">{{ $profile->height ?? 'Height not provided' }}</span><span
                                                    class="metric">m</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="profile-info">
                                            <div class="profile-interest">
                                                <span class="material-symbols-outlined">heart_check</span>
                                                {{ $profile->interested_in->getLabel() }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="profile-info">
                                            <div class="profile-seeking">
                                                <span class="material-symbols-outlined">search</span>
                                                {{ $profile->seeking->getLabel() }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="profile-info">
                                            <div class="profile-seeking">
                                                <span class="material-symbols-outlined">wc</span>
                                                {{ $profile->gender->getLabel() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <div class="profile-info">
                                            <div class="profile-traits">
                                                <span class="material-symbols-outlined">waving_hand</span>
                                                @php
                                                    $my_traits = Auth::user()->traits->pluck('id');
                                                @endphp
                                                @foreach ($profile->user->traits as $trait)
                                                    <span
                                                        @class(['comma-after', 'fw-bold' => $my_traits->contains($trait->id)])>{{ $trait->name }}{{ $trait->emoji }}</span>
                                                @endforeach
                                                @if (count($profile->user->traits) == 0)
                                                    <span>No traits specified</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="profile-info">
                                            <div class="profile-interests">
                                                <span class="material-symbols-outlined">interests</span>
                                                @php
                                                    $my_interests = Auth::user()->interests->pluck('id');
                                                @endphp
                                                @foreach ($profile->user->interests as $interest)
                                                    <span
                                                        @class([
                                                            'comma-after',
                                                            'fw-bold' => $my_interests->contains($interest->id),
                                                        ])>{{ $interest->name }}{{ $interest->emoji }}</span>
                                                @endforeach
                                                @if (count($profile->user->interests) == 0)
                                                    <span>No interests specified</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="profile-bio">{{ $profile->bio }}</div>
                                @if ($date_ideas)
                                    <hr>
                                    <div class="row" id="date-ideas">
                                        <div class="col-12">
                                            <h5>✨ Personalised Date Ideas</h5>
                                            {!! $date_ideas->content !!}
                                            <img class="chatgpt-logo mt-3"
                                                src="{{ asset('./images/logos/powered-by-openai-badge-filled-on-light.svg') }}"
                                                alt="Powered by OpenAI">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
    <div style="margin-top: 20px;"></div>
    <div class="container favorites-container mt-6">
        <div class="card profile-card">
            <h1 class="favorites-title text-uppercase">My Favorites</h1>
            <div class="row row-cols-1 row-cols-md-3 g-3">
                <div class="col">
                    <div class="favorite-square">
                        <span class="material-symbols-outlined icon">headphones</span>
                        <div class="favorite-item text-uppercase">{{ $profile->fav_song ?? 'Favorite Song' }}
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="favorite-square">
                        <span class="material-symbols-outlined icon">movie</span>
                        <div class="favorite-item text-uppercase">{{ $profile->fav_movie ?? 'Favorite Movie' }}
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="favorite-square">
                        <span class="material-symbols-outlined icon">restaurant</span>
                        <div class="favorite-item text-uppercase">{{ $profile->fav_food ?? 'Favorite Food' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
