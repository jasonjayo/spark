@props(['message', 'code'])

<x-app-layout>
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-sm-12 offset-lg-4">
                <div class="card mt-5">
                    <div class="card-body">
                        <h5 class="card-title">Something went wrong</h5>
                        <p class="card-text">
                            {{ $message ?? 'An error occurred. No further information is available. ' }}
                            @isset($code)
                                ({{ $code }})
                            @endisset
                        </p>
                        <a href="#" onclick="history.back()" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
        </div>
        <div id="error-box">

        </div>
</x-app-layout>
