<x-app-layout>

    <x-slot:title>Discovery Queue</x-slot>

    <div class="text-center p-4">
        <h2><b>✨ Your Personalised Discovery Queue</b></h2>
        <p class="m-0">View profiles selected just for you.</p>
    </div>
    <div class="container">

        @php
            $recommendation = $recommendations->first();
        @endphp
        @if ($recommendation !== null)
            <div class="row">
                <div class="col text-center">
                    <div class="recommendation-score mx-auto my-3">
                        <div class="recommendation-bar bg-success"
                            style='width:{{ $recommendation->pivot->weight * 3 }}px'>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4"></div>

                <div class=" col-12 col-md-4">
                    <x-profile-card :profile="$recommendation->profile" />
                </div>
                <div class="colmd--4"></div>

            </div>

            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-center mt-3 mb-3">
                        <form action="react" method="POST" class="p-3">
                            @csrf
                            <input hidden type="text" name="id" value="{{ $recommendation->id }}">
                            <input hidden type="text" name="type" value="LIKE">
                            <button type="submit" class="btn btn-primary fs-4 text-uppercase"><i
                                    class="bi bi-check"></i><b>Like</b></button>
                        </form>
                        <form action="react" method="POST" class="p-3">
                            @csrf
                            <input hidden type="text" name="id" value="{{ $recommendation->id }}">
                            <input hidden type="text" name="type" value="DISLIKE">
                            <button type="submit" class="btn btn-primary fs-4 text-uppercase"><i
                                    class="bi bi-x"></i><b>Dislike</b></button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-12 text-center mt-5">
                    <div class="mb-3">
                        <i class="bi bi-check-square-fill" id="discovery-empty-icon"></i>
                    </div>
                    <b class="fs-5">You've completed your discovery queue for now.<br>
                        Come back later!</b>
                </div>
            </div>
        @endif

    </div>



</x-app-layout>
