<x-app-layout>

    <x-slot:title>Dashboard</x-slot>

    <style>
        #welcomeTitle {
            color: var(--spk-color-primary-1);
        }

        .material-symbols-outlined {
            color: var(--spk-color-primary-1);
            font-size: 1.5em;
        }

        #gettingStarted {
            font-size: 1.25em;
        }

        .completed-item .material-symbols-outlined {
            color: inherit;
        }
    </style>

    @php
        $hasProfile = isset(Auth::user()->profile);
        $hasPhotos = count(Auth::user()->photos) > 0;
        $hasMatches = count(Auth::user()->getMatches()) > 0;
        $hasUsedDiscovery =
            DB::table('reactions')
                ->where('sender_id', '=', Auth::user()->id)
                ->count() > 0;
    @endphp

    <div class="container">
        <div class="row text-center mt-5 justify-content-center">
            <div class="col-md-8">
                <h1 id="welcomeTitle" class="fw-bold d-flex align-items-center justify-content-center">
                    Welcome to <x-application-logo class="ms-3" id="dashboard-logo"></x-application-logo>
                </h1>
            </div>
        </div>
        <div class="row text-center justify-content-center">
            <div class="col-md-8">
                <p>Here's a checklist to help you get started!</p>
            </div>
        </div>
        <div class="row mt-4 justify-content-center">
            <div class="col-md-6">
                <ul class="list-group" id="gettingStarted">
                    <a href="{{ route('profile.edit') }}" class="list-group-item text-black text-   coration-none">
                        <li @class([
                            'd-flex align-items-center',
                            'text-decoration-line-through text-body-tertiary completed-item' => $hasProfile,
                        ])>
                            <span class="material-symbols-outlined me-4">
                                person
                            </span>
                            Create your profile
                        </li>
                    </a>
                    <a href="{{ route('profile.edit') }}/?section=section4"
                        class="list-group-item text-black text-decoration-none">
                        <li @class([
                            'd-flex align-items-center',
                            'text-decoration-line-through text-body-tertiary completed-item' => $hasPhotos,
                        ])>
                            <span class="material-symbols-outlined me-4">
                                add_to_photos
                            </span>
                            Add some photos
                        </li>
                    </a>
                    <a href="{{ route('discovery') }}" class="list-group-item text-black text-decoration-none">
                        <li @class([
                            'd-flex align-items-center',
                            'text-decoration-line-through text-body-tertiary completed-item' => $hasUsedDiscovery,
                        ])>
                            <span class="material-symbols-outlined me-4">
                                favorite
                            </span>
                            Explore your personalised Discovery Queue
                        </li>
                    </a>
                    <a href="{{ route('search') }}" class="list-group-item text-black text-decoration-none">
                        <li class="d-flex">
                            <span class="material-symbols-outlined me-4">
                                search
                            </span>
                            Find other users
                        </li>
                    </a>
                    <a href="{{ route('chat.index') }}" class="list-group-item text-black text-decoration-none">
                        <li @class([
                            'd-flex align-items-center',
                            'text-decoration-line-through text-body-tertiary completed-item' => $hasMatches,
                        ])>
                            <span class="material-symbols-outlined me-4">
                                chat
                            </span>
                            Chat with your matches
                        </li>
                    </a>
                </ul>
            </div>
        </div>
        <div class="row justify-content-center my-3 gx-4 gy-5">
            <div class="col-md-6">
                <a href="{{ route('discovery') }}" class="dashbtn shadow-lg ">
                    <div class="dashbtn-background"
                        style="background-image: url({{ asset('/images/dashboard/pexels-taryn-elliott-4390580.jpg') }})">
                    </div>
                    <span>Discovery Queue</span>
                </a>
            </div>
            <div class="col-md-6">
                <a href="{{ route('search') }}" class="dashbtn shadow-lg">
                    <div class="dashbtn-background"
                        style="background-image: url({{ asset('/images/dashboard/discovery.jpeg') }})">
                    </div>
                    <span>Search</span>
                </a>
            </div>
            <div class="col-12">
                <a href="{{ route('viewprofile', Auth::user()->id) }}" class="dashbtn dashbtn--small shadow-lg">
                    <div class="dashbtn-background"
                        style="background-image: url({{ asset('/images/dashboard/pexels-arina-krasnikova-7350875.jpg') }})">
                    </div>
                    <span>Preview Your Profile</span>
                </a>
            </div>
        </div>

        <footer class="mt-5 text-center text-body-tertiary">
            Developed by Jason Gill, Caragh Morahan, Kamil Mrowiec &amp; Roy Flaherty.
        </footer>
</x-app-layout>
