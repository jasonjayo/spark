<x-app-layout>

    <x-slot:title>Dashboard</x-slot>

    <div class="container-fluid">
        Welcome back, {{ Auth::user()->first_name }}
        <div class="row justify-content-md-center">
            <a href="" class="dashbtn shadow-lg col-5">
                <img width="fit" src="{{ asset('./images/dashboard/pexels-taryn-elliott-4390580.jpg') }}" />
                <span>Discovery Queue</span>
            </a>
            <div style="width: 16px"> </div>
            <a href="" class="dashbtn shadow-lg col-5"><img width="fit"
                    src="{{ asset('./images/dashboard/discovery.jpeg') }}" />
                <span>Speed-Dating</span></a>
        </div>
    </div>

    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}


</x-app-layout>
