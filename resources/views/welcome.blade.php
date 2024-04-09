<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('./images/logos/spark_small.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/css/guest.css', 'resources/js/app.js'])

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Styles -->

    <style>
    </style>
</head>

<body class="antialiased overflow-hidden min-h-screen welcome text-white text-center">
    <div class="hero shadow">
        <img height="fit" src="{{ asset('./images/dashboard/pexels-taryn-elliott-4390580.jpg') }}" />
        <div class="hero-text">
            <h1 class="cover-heading"><x-application-logo id="hero-logo"></x-application-logo></h1>
            <p class="lead">Spark a connection. Speed Dating, make a real connection.</p>
        </div>
    </div>
    <div class="cover-container container d-flex h-100 p-3 mx-auto flex-column">
        <div class="inner-cover">


            @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-lg mx-2 mt-4 btn-secondary">Dashboard</a>
                    @else
                        <div class="d-flex">
                            <a href="{{ route('login') }}" class="btn btn-lg mx-2 btn-secondary">Log
                                in</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-lg mx-2 btn-secondary">Register</a>
                            @endif
                        </div>
                    @endauth
                </div>
            @endif
        </div>

    </div>
</body>

</html>
