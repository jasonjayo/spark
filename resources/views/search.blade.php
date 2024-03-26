<x-app-layout>
    <div class="container">
        <form action="" method="GET" class="row row-cols-lg-auto g-3 align-items-center">
            <div class="col-12">
                <label for="filter_min_age" class="form-label">Min age</label>
                <input type="range" class="form-range" min="18" max="100" id="filter_min_age" name="min_age">
            </div>
            <div class="col-12">
                <label for="filter_max_age" class="form-label">Max age</label>
                <input type="range" class="form-range" min="18" max="100" id="filter_max_age"
                    name="max_age">
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

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
