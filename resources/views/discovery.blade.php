<x-app-layout>

    <x-slot:title>Discovery Queue</x-slot>

    <h1>Discovery Queue</h1>


    <div class="container">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 m-4 g-4">
            @foreach ($recommendations as $recommended_user)
                <div class="col">
                    <x-profile-card :profile="$recommended_user->profile" />
                    {{ $recommended_user->pivot->weight }}
                </div>
            @endforeach
        </div>
    </div>


</x-app-layout>
