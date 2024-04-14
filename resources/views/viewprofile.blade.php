@props(['profile'])
@use('PhpGeoMath\Model\Polar3dPoint')
@use ('App\Models\Photo')

<head>

    <x-app-layout>
        <x-slot:title>{{ $profile->user->first_name }}'s profile</x-slot>

        <?php
        $photoUrls = [];
        ?>

        @foreach (Photo::where('user_id', $profile->user_id)->get() as $photo)
            <?php array_push($photoUrls, $photo->photo_url); ?>
        @endforeach

        <div class="container profile-container">
            <section class="mt-6 space-y-6">
                <div class="card profile-card">
                    <div class="row g-0">
                        <div class="col-lg-4 col-md-12 mb-3 mb-lg-0">
                            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">

                                    @foreach ($photoUrls as $index => $photoUrl)
                                        <?php
                                        if ($index == 0) {
                                            $activeClass = 'carousel-item active';
                                        } elseif ($index > 0) {
                                            $activeClass = 'carousel-item';
                                        }
                                        ?>

                                        <div class="{{ $activeClass }}">
                                            <img src="{{ asset('images/profilePhotos/' . $photoUrl) }}"
                                                class="d-block w-100" alt="Photo 1">
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
                                        <h2 class="profile-name">{{ $profile->user->first_name }}, <span
                                                class="age">{{ $profile->getAge() }}</span></h2>
                                    </div>
                                    <div class="profile-languages"><span class="speaking">I speak</span>
                                        {{ $profile->languages }}</div>
                                    <div class="profile-work"><span class="workingat">Work</span> {{ $profile->work }}
                                    </div>
                                    <div class="profile-university"><span class="studyingat">University</span>
                                        {{ $profile->university }}</div>
                                    @if ($profile->getDistance() != null)
                                        <div class="profile-location">
                                            <span class="livingat">Home</span>
                                            <span class="distance">{{ $profile->getDistance() }}</span>
                                        </div>
                                    @endif

                                    <div class="profile-interests">
                                        <span class="interests">Interests</span>
                                        @php
                                            $my_interests = Auth::user()->interests->pluck('id');
                                            $my_traits = Auth::user()->traits->pluck('id');
                                        @endphp
                                        @foreach ($profile->user->interests as $interest)
                                            <span @class(['fw-bold' => $my_interests->contains($interest->id)])>{{ $interest->name }}</span>
                                        @endforeach
                                    </div>

                                    <div class="profile-traits">
                                        <span class="traits">Traits</span>
                                        @foreach ($profile->user->traits as $trait)
                                            <span @class(['fw-bold' => $my_traits->contains($trait->id)])>{{ $trait->name }}</span>
                                        @endforeach
                                    </div>

                                    <div class="profile-others">
                                        <div class="profile-personality">{{ $profile->personality_type }}</div>
                                        <div class="profile-height">{{ $profile->height }}<span class="metric">m</span>
                                        </div>
                                        <div class="profile-interest">{{ $profile->interested_in->getLabel() }}</div>
                                        <div class="profile-seeking">{{ $profile->seeking->getLabel() }}</div>
                                    </div>
                                    <div class="profile-line"></div>
                                    <div class="profile-tagline">{{ $profile->tagline }}</div>
                                    <div class="profile-bio">{{ $profile->bio }}</div>

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
                            <div class="favorite-item text-uppercase">{{ $profile->fav_song }}</div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="favorite-square">
                            <span class="material-symbols-outlined icon">movie</span>
                            <div class="favorite-item text-uppercase">{{ $profile->fav_movie }}</div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="favorite-square">
                            <span class="material-symbols-outlined icon">restaurant</span>
                            <div class="favorite-item text-uppercase">{{ $profile->fav_food }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Link to the CSS file -->
        <link href="{{ asset('css/viewprofile.css') }}" rel="stylesheet">
    </x-app-layout>
