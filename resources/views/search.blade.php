@use('App\Enums\Gender')
@use('App\Models\Interest')

@pushOnce('scripts')
    @vite(['resources/js/search.js', 'resources/css/search.css'])
@endPushOnce

<x-app-layout>
    <div class="fluid-container m-0 min-h-screen">
        <div class="search row">
        <form class="col-12 sideform col-md-5 col-lg-3 d-flex flex-column" action="" method="GET" id="filters_form"
            >
            <div class="form-label-group my-3 mx-4">
                <label for="filter_min_age" class="form-label">Min age</label>
                <span id="min_age_val">{{ old('min_age', '18') }}</span>
                <input type="range" class="form-range" min="18" max="100" value="{{ old('min_age', '18') }}"
                    id="filter_min_age" name="min_age">
            </div>
            <div class="form-label-group my-3 mx-4">
                <label for="filter_max_age" class="form-label">Max age</label>
                <span id="max_age_val">{{ old('max_age', '100') }}</span>
                <input type="range" class="form-range" min="18" max="100"
                    value="{{ old('max_age', '100') }}" id="filter_max_age" name="max_age">
            </div>
            <div class="form-label-group my-3 mx-4">
                <label for="filter_gender" class="form-label">Gender</label>
                <select class="form-select" name="gender" id="filter_gender">
                    <option value="all">All</option>
                    @foreach (Gender::cases() as $gender)
                        <option value="{{ $gender->value }}" {{ $gender->value == old('gender') ? 'selected' : '' }}>
                            {{ $gender->getLabel() }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-label-group my-3 mx-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="yes"
                        {{ old('online_now') == 'yes' ? 'checked' : '' }} id="filter_online_now" name="online_now">
                    <label class="form-check-label" for="filter_online_now">
                        Online now
                    </label>
                </div>
            </div>
            <div class="form-label-group my-3 mx-4">
                <div class="dropdown">
                    <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
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
        </form>

       

        <div class="col-12 col-md-7 col-lg-9">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 m-4 g-4">
                @foreach ($profiles as $profile)
                    <div class="col">
                        <x-profile-card :profile="$profile" />
                    </div>
                @endforeach
                <div class="mb-4">{{ $sql }}</div>

            </div>
        </div>
    </div>
</x-app-layout>
