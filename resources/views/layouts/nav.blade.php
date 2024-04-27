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
</style>
<div class="alert alert-secondary mb-0" role="alert" x-cloak x-data x-show="window.location.host === '78.153.209.28'">
    Please access the site through <a href="https://findyourspark.ie">findyourspark.ie</a>
</div>
<nav class="nav
    navbar d-flex fixed-top justify-content-between p-3 position-relative z-1 bg-white">

    @php
        if (Auth::user()->isAdmin()) {
            $home = route('admin');
        } else {
            $home = route('dashboard');
        }
    @endphp
    <a href="{{ $home }}"><img class="nav-logo" src="{{ asset('./images/logos/spark_no_subtitle.png') }}"
            alt=""></a>

    <div class="d-none d-md-flex">
        <ul class="nav-links list-group d-flex flex-row justify-content-center fs-5">
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

        </ul>
    </div>
</nav>

<nav class="bottomnav navbar d-flex d-md-none fixed-bottom justify-content-around z-4 spark-bg-primary">
    <ul class="nav-links list-group d-flex flex-row justify-content-center fs-5">
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
