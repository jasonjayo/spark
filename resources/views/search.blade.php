@use('App\Enums\Gender')

@pushOnce('scripts')
    @vite(['resources/js/search.js'])
@endPushOnce

<x-app-layout>
    <div class="container">
        <form action="" method="GET" id="filters_form" class="row row-cols-lg-auto g-3 align-items-center">
            <div class="col-12">
                <label for="filter_min_age" class="form-label">Min age</label>
                <input type="range" class="form-range" min="18" max="100" value="{{ old('min_age', '18') }}"
                    id="filter_min_age" name="min_age">
                <span id="min_age_val">{{ old('min_age', '18') }}</span>
            </div>
            <div class="col-12">
                <label for="filter_max_age" class="form-label">Max age</label>
                <input type="range" class="form-range" min="18" max="100"
                    value="{{ old('max_age', '100') }}" id="filter_max_age" name="max_age">
                <span id="max_age_val">{{ old('max_age', '100') }}</span>
            </div>
            <div class="col-12">
                <label for="filter_gender" class="form-label">Gender</label>
                <select class="form-select" name="gender" id="filter_gender">
                    <option value="all">All</option>
                    @foreach (Gender::cases() as $gender)
                        <option value="{{ $gender->value }}" {{ $gender->value == old('gender') ? 'selected' : '' }}>
                            {{ $gender->getLabel() }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="yes"
                        {{ old('online_now') == 'yes' ? 'checked' : '' }} id="filter_online_now" name="online_now">
                    <label class="form-check-label" for="filter_online_now">
                        Online now
                    </label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
            {{-- this button needed if auto refresh? --}}
        </form>

        <a href="./search">Reset</a>

        <div class="container">
            <div class="row row-cols-1 row-cols-md-4 g-4">
                @foreach ($profiles as $profile)
                    <div class="col">
                        <x-profile-card :profile="$profile" />
                    </div>
                @endforeach
            </div>
        </div>
</x-app-layout>
