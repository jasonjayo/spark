@use('App\Enums\Gender')

@pushOnce('scripts')
    @vite(['resources/js/search.js'])
@endPushOnce

<x-app-layout>
    <div class="container">
        <form action="" method="GET" class="row row-cols-lg-auto g-3 align-items-center">
            <div class="col-12">
                <label for="filter_min_age" class="form-label">Min age</label>
                <input type="range" class="form-range" min="18" max="100" value="{{ old('min_age', '18') }}"
                    id="filter_min_age" name="min_age">
                <span id="min_age_val">{{ old('min_age', '18') }}</span>
            </div>
            <div class="col-12">
                <label for="filter_max_age" class="form-label">Max age</label>
                <input type="range" class="form-range" min="18" max="100"
                    value="{{ old('max_age', '25') }}" id="filter_max_age" name="max_age">
                <span id="max_age_val">{{ old('max_age', '25') }}</span>
            </div>
            <div class="col-12">
                <label for="filter_gender" class="form-label">Gender</label>
                <select class="form-select" name="gender" id="filter_gender">
                    @foreach (Gender::cases() as $gender)
                        <option value="{{ $gender->value }}" {{ $gender->value == old('gender') ? 'selected' : '' }}>
                            {{ $gender->getLabel() }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
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
