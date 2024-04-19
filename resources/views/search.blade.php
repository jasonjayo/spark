@use('App\Enums\Gender')
@use('App\Models\Interest')

@pushOnce('scripts')
    @vite(['resources/js/search.js', 'resources/css/search.css'])
@endPushOnce

<x-app-layout>
    <x-slot:title>Search</x-slot>


    <div class="fluid-container search m-0">
        <div class=" row">
            <form class="col-12 sideform col-md-5 col-lg-3 d-flex flex-column" action="" method="GET"
                id="filters_form">

                <div class="sticky-top">
                    <div class="form-floating my-3 mx-4">
                        <input type="text" class="form-control" id="filter_query" name="query"
                            placeholder="Search name, tagline" autocomplete="off" value="{{ old('query') }}">
                        <label for="filter_query">Search name, tagline</label>
                    </div>
                    <div class="form-label-group my-3 mx-4" x-data="{ min_age: {{ old('min_age', 18) }} }">
                        <label for="filter_min_age" class="form-label">Min age</label>
                        <span id="min_age_val" x-text="min_age"></span>
                        <input type="range" class="form-range" min="18" max="100" id="filter_min_age"
                            name="min_age" x-model="min_age">
                    </div>
                    <div class="form-label-group my-3 mx-4" x-data="{ max_age: {{ old('max_age', 100) }} }">
                        <label for="filter_max_age" class="form-label">Max age</label>
                        <span id="max_age_val" x-text="max_age"></span>
                        <input type="range" class="form-range" min="18" max="100" id="filter_max_age"
                            name="max_age" x-model="max_age">
                    </div>
                    <div class="form-label-group my-3 mx-4" x-data="{ max_distance: {{ old('max_distance', 100) }} }">
                        <label for="filter_max_distance" class="form-label">Max distance</label>
                        <span id="max_distance_val" x-text="max_distance"></span><span
                            x-show="max_distance >= 100">+</span> km
                        <input type="range" class="form-range" min="1" max="100" id="filter_max_distance"
                            name="max_distance" x-model="max_distance">
                    </div>
                    <div class="form-label-group my-3 mx-4">
                        <label for="filter_gender" class="form-label">Gender</label>
                        <select class="form-select" name="gender" id="filter_gender">
                            <option value="all">All</option>
                            @foreach (Gender::cases() as $gender)
                                <option value="{{ $gender->value }}"
                                    {{ $gender->value == old('gender') ? 'selected' : '' }}>
                                    {{ $gender->getLabel() }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-label-group my-3 mx-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="yes"
                                {{ old('online_now') == 'yes' ? 'checked' : '' }} id="filter_online_now"
                                name="online_now">
                            <label class="form-check-label" for="filter_online_now">
                                Online now
                            </label>
                        </div>
                    </div>
                    <div class="form-label-group my-3 mx-4">
                        <div class="dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Interests
                            </button>
                            <ul class="dropdown-menu">
                                @foreach (DB::table('interests')->get() as $interest)
                                    <li><a href="#" class="dropdown-item interest_option"
                                            data-interest-id="{{ $interest->id }}">{{ $interest->name }}</a></li>
                                @endforeach
                            </ul>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between my-3 mx-4">
                        <a class="btn btn-outline-secondary" href="./search">Reset</a>
                        <button class="btn btn-primary">Search</button>

                    </div>
                    <div class="col-12 w-100">
                        @foreach (array_filter(explode(',', old('interests'))) as $interest_id)
                            <span class="interest-pill badge rounded-pill p-2 text-bg-secondary"
                                data-interest-id="{{ $interest_id }}">
                                {{ Interest::find($interest_id)->name }}
                                <button type="button" class="btn-close ms-1" aria-label="Close"></button>
                            </span>
                        @endforeach

                    </div>

                    <input hidden type="text" id="filter_interests" name="interests" value={{ old('interests') }}>
                </div>
            </form>


            @foreach ($errors as $error)
                <div id="toasts">
                    <div class="toast show align-items-center text-bg-primary bg-danger border-0" role="alert"
                        aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                {{ $error }}
                            </div>
                            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                                aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            @endforeach


            <div class="col-12 col-md-7 col-lg-9">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 m-4 g-4">
                    @foreach ($profiles as $profile)
                        <div class="col">
                            <x-profile-card :profile="$profile" />
                        </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-12 col-sm-6">
                        {{ $profiles->links() }}
                    </div>
                </div>
            </div>


            <div class="col-12">
                <div class="row">
                </div>
            </div>

            <script>
                // debug
            </script>
            {{-- {{ $sql }} --}}
</x-app-layout>
