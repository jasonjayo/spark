<style>
    .nav-logo {
        width: 100%;
    }

    @media (min-width: 768px) {
        .nav-logo {
            height: 70px;
        }
    }

    .spark-bg-primary {
        background: #DE3163
    }

    .spark-bg-secondary {
        background: #B61A47;
    }

    .nav {
        border-bottom: 2px solid var(--spk-color-primary-2);
    }

    .bottomnav {
        border-top: 2px solid var(--spk-color-primary-2);
        padding: 0;
    }

    #links {
        min-height: 70vh;
    }

    #notifications {
        position: absolute;
        right: 1.5em;
        top: 5em;
        width: min(80vw, 350px);
        background: #fff;

        .btn-close {
            font-size: 14px;
        }
    }

    #notification-count {
        left: 70%;
        top: 30%;
    }

    .notification-ago {
        font-size: 0.9em;
    }
</style>
<div class="alert alert-secondary mb-0" role="alert" x-cloak x-data x-show="window.location.host === '78.153.209.28'">
    Please access the site through <a href="https://findyourspark.ie">findyourspark.ie</a>
</div>

@php
    $notifications = Auth::user()->notifications;

    $timeAgo = new Westsworld\TimeAgo();
@endphp

<nav id ="nav" class="nav
    navbar d-flex fixed-top justify-content-between p-3 position-relative z-1 bg-white"
    x-data="{ notificationsVisible: false, notificationsCount: {{ count($notifications) }} }">

    @php
        if (Auth::user()->isAdmin()) {
            $home = route('admin');
        } else {
            $home = route('dashboard');
        }
    @endphp

    <div id="notifications" class="z-2 p-3 shadow" x-cloak x-show="notificationsVisible"
        @click.outside="notificationsVisible = false">

        @foreach ($notifications as $notification)
            <div
                class="notification d-flex justify-content-between align-items-center border-3 border-bottom mb-2 mt-2 ps-3 pt-2 pb-2">
                @if ($notification->link)
                    <a class="text-decoration-none text-black" href="{{ $notification->link }}">
                @endif
                <div>
                    <h6>{{ $notification->title }} </h6>
                    <div class="notification-ago mb-1 text-secondary">
                        {{ $timeAgo->inWords(new DateTime($notification->timestamp)) }}
                    </div>
                    <span> {{ $notification->contents }}</span>
                </div>
                @if ($notification->link)
                    </a>
                @endif
                <button type="button" data-notification-id="{{ $notification->id }}"
                    @click="dismissNotification($el, $data)" class="btn-close notification-close-btn ms-3"
                    aria-label="Close"></button>
            </div>
        @endforeach
        <div x-show="notificationsCount <= 0">No notifications</div>
    </div>

    <a href="{{ $home }}"><img class="nav-logo" src="{{ asset('./images/logos/spark_no_subtitle.png') }}"
            alt=""></a>

    <div class="d-none d-md-flex">
        <ul class="nav-links list-group d-flex flex-row justify-content-center fs-5">
            @if (Auth::user()->isAdmin())
                <a href="{{ route('admin') }}" class="text-decoration-none text-black">
                    <li @class([
                        'p-3 mr-3 px-4 rounded d-flex text-center align-items-center',
                        'spark-bg-secondary text-white' => Request::is('admin'),
                    ])>
                        <i class="bi-gear icon"> </i>
                        <span class="d-none mx-2 d-lg-flex">Admin Dashboard</span>
                    </li>
                </a>
            @endif
            @if (!Auth::user()->isAdmin())
                <a href="{{ route('discovery') }}" class="text-decoration-none text-black">
                    <li @class([
                        'p-3 mr-3 px-4 rounded d-flex text-center align-items-center',
                        'spark-bg-secondary text-white' => Request::is('discovery'),
                    ])>
                        <i class="bi-stars icon"> </i>
                        <span class="d-none mx-2 d-lg-flex">Discover</span>
                    </li>
                </a>
            @endif
            <a href=" {{ route('search') }}" class="text-decoration-none text-black">
                <li @class([
                    'p-3 mr-3 px-4 rounded d-flex text-center align-items-center',
                    'spark-bg-secondary text-white' => Request::is('search'),
                ])>
                    <i class="bi-search icon"> </i><span class="d-none mx-2 d-lg-flex">Search</span>
                </li>
            </a>
            @if (!Auth::user()->isAdmin())
                <a href="{{ route('chat.index') }}" class="text-decoration-none text-black">
                    <li @class([
                        'p-3 mr-3 px-4 rounded d-flex text-center align-items-center',
                        'spark-bg-secondary text-white' => Str::contains(
                            request()->route()->getName(),
                            'chat'),
                    ])>
                        <i class="bi-chat-dots icon"></i><span class="d-none mx-2 d-lg-flex">Chat</span>
                    </li>
                </a>
            @endif

            @if (!Auth::user()->isAdmin())
                <a href="{{ route('profile.edit') }}" class="text-decoration-none text-black">
                    <li @class([
                        'p-3 mr-3 px-4 rounded d-flex text-center align-items-center',
                        'spark-bg-secondary text-white' => Request::is('profile'),
                    ])>
                        <i class="bi-person icon"></i>
                        <span class="d-none mx-2 d-lg-flex">Profile</span>

                    </li>
                </a></a>
            @endif

            @if (!Auth::user()->isAdmin())
                <li role="button" @class([
                    'p-3 px-4 rounded d-flex text-center align-items-center position-relative',
                ]) @click="notificationsVisible = !notificationsVisible">
                    <i class="bi-bell icon"></i>
                    <span id="notification-count" x-cloak x-show="notificationsCount > 0"
                        class="position-absolute translate-middle badge rounded-pill bg-danger">
                        <span x-text="notificationsCount"></span>
                        <span class="visually-hidden">unread messages</span>
                    </span>
                </li>
            @endif
        </ul>
    </div>
</nav>

{{-- mobile nav --}}
<nav class="bottomnav navbar d-flex d-md-none fixed-bottom justify-content-around z-4 spark-bg-primary">
    <ul class="nav-links list-group d-flex flex-row justify-content-center fs-5">
        @if (Auth::user()->isAdmin())
            <a href="{{ route('admin') }}" class="text-decoration-none text-black">
                <li @class([
                    'p-3 mr-3 px-4 rounded d-flex text-center align-items-center',
                    'spark-bg-secondary' => Request::is('admin'),
                ])>
                    <i class="bi-gear fs-1 text-white"> </i>
                </li>
            </a>
        @endif

        @if (!Auth::user()->isAdmin())
            <a href="{{ route('discovery') }}" class="text-decoration-none text-black">
                <li @class([
                    'p-3 mr-3 px-4 rounded d-flex text-center align-items-center',
                    'spark-bg-secondary' => Request::is('discovery'),
                ])>
                    <i class="bi-stars fs-1 text-white"> </i>
                </li>
            </a>
        @endif

        <a href="{{ route('search') }}" class="text-decoration-none text-black">
            <li @class([
                'p-3 mx-3 px-4 rounded d-flex text-center align-items-center',
                'spark-bg-secondary' => Request::is('search'),
            ])>
                <i class="bi-search fs-1 text-white"> </i>
            </li>
        </a>

        @if (!Auth::user()->isAdmin())
            <a href="{{ route('chat.index') }}" class="text-decoration-none text-black">
                <li class="p-3 mx-3 px-4 rounded d-flex text-center align-items-center">
                    <i class="bi-chat-dots fs-1 text-white"></i>
                </li>
            </a>
        @endif

        @if (!Auth::user()->isAdmin())
            <a href="{{ route('profile.edit') }}" class="text-decoration-none text-black">
                <li @class([
                    'p-3 ml-3 px-4 rounded d-flex text-center align-items-center',
                    'spark-bg-secondary' => Request::is('profile'),
                ])>
                    <i class="bi-person fs-1 text-white"></i>

                </li>
            </a>
        @endif


    </ul>
</nav>

<script>
    const notificatipnCloseBtns = document.querySelectorAll(".notification-close-btn");

    function dismissNotification(el, data) {
        const id = el.getAttribute("data-notification-id");
        axios.post(`${URL_BASE}/api/dismissNotification`, {
            id
        }).then(res => {
            console.log(res);
            if (res.status === 200) {
                data.notificationsCount -= 1;
                el.parentElement.remove();
            }
        });
    }
    //     notificatipnCloseBtns.forEach(btn => {
    //         const id = btn.getAttribute("data-notification-id");
    //         btn.addEventListener("click", e => {
    //             axios.post(`${URL_BASE}/api/dismissNotification`, {
    //                 id
    //             }).then(res => {
    //                 e.target.parentElement.remove();
    //             })
    //         });
    //     });
    //
</script>
{{-- <div class="container-fluid">
    <a class="navbar-brand" href="#">Expand at md</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample04"
        aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExample04">
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" aria-disabled="true">Disabled</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"
                    aria-expanded="false">Dropdown</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
            </li>
        </ul>
        <form role="search" data-np-autofill-form-type="other" data-np-checked="1" data-np-watching="1">
            <input class="form-control" type="search" placeholder="Search" aria-label="Search">
        </form>
    </div>
</div> --}}
