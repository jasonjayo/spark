<x-app-layout>
    <x-slot:title>Error</x-slot>

    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-sm-12 offset-lg-4">
                <div class="card mt-5">
                    <div class="card-body">
                        <h5 class="card-title">Something went wrong</h5>
                        <p class="card-text">
                            {{ session('message') ?? 'An error occurred. No further information is available. ' }}
                            @if (session('code'))
                                ({{ session('code') }})
                            @endif
                        </p>
                        <a href="#" onclick="history.back()" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
        </div>
        <div id="error-box">

        </div>
</x-app-layout>
