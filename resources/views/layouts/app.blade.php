<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ ($title ?? "") . " | " . config('app.name') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('./images/logos/spark_small.png') }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Scripts -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

</head>

<body class="font-sans antialiased">
    <div class="min-h-screen default spk-bg">
        @include('layouts.nav')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        {{-- <div class="position-fixed top-0 left-0 bottom-0 spark-bg-primary d-flex">
            <ul class="nav-links list-group text-white d-flex flex-column justify-content-center fs-5">
                <a href="./dashboard" class="text-decoration-none text-white">
                    <li
                        class="p-3 m-3 rounded  d-flex flex-column text-center {{ Request::is('dashboard') ? 'spark-bg-secondary' : '' }}">
                        <span class="material-symbols-outlined fs-1">
                            star
                        </span>Discover
                    </li>
                </a>
                <li class="p-3 m-3 d-flex flex-column text-center"><span class="material-symbols-outlined fs-1">
                        search
                    </span>Search</li>
                <li class="p-3 m-3 d-flex flex-column text-center"><span class="material-symbols-outlined fs-1">
                        chat
                    </span>Chat</li>
                <li class="p-3 m-3 d-flex flex-column text-center"><span class="material-symbols-outlined fs-1 ">
                        person
                    </span>Profile</li>



            </ul>
        </div> --}}



        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
        {{--
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <x-responsive-nav-link class="btn btn-primary m-4" :href="route('logout')"
                onclick="event.preventDefault();
                                this.closest('form').submit();">
                {{ __('Log Out') }}
            </x-responsive-nav-link>
        </form> --}}
    </div>
    @stack('scripts')
</body>

</html>
