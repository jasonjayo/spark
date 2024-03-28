<style>
    .nav-logo {
        height: 70px;
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

    #links {
        min-height: 70vh;
    }
</style>
<nav class="nav navbar d-flex mb-5 fixed-top justify-content-between p-4 position-relative z-1 bg-white">
    <a href=" {{ route('dashboard') }}"><img class="nav-logo" src="{{ asset('./images/logos/spark_no_subtitle.png') }}"
            alt=""></a>

    <div class="d-none d-md-flex">
        <ul class="nav-links list-group d-flex flex-row justify-content-center fs-5">
            <a href="./dashboard" class="text-decoration-none text-black">
                <li @class([
                    'p-3 ms-3 me-3 rounded rounded d-flex text-center align-items-center',
                    'spark-bg-secondary text-white' => Request::is('dashboard'),
                ])>
                    <i class="bi-stars fs-1 pe-2"> </i>
                    <span class="d-none d-lg-flex">Discover</span>
                </li>
            </a>
            <a href="./search" class="text-decoration-none text-black">
                <li @class([
                    'p-3 ms-3 me-3 rounded rounded d-flex text-center align-items-center',
                    'spark-bg-secondary text-white' => Request::is('search'),
                ])>
                    <i class="bi-search fs-1 pe-2"> </i><span class="d-none d-lg-flex">Search</span>
                </li>
            </a>
            <a href="./search" class="text-decoration-none text-black">
                <li class="p-3 ms-3 me-3 rounded d-flex text-center align-items-center">
                    <i class="bi-chat-dots fs-1 pe-2"></i><span class="d-none d-lg-flex">Chat</span>
                </li>
            </a>

            <a href="./profile" class="text-decoration-none text-black">
                <li @class([
                    'p-3 ms-3 me-3 rounded rounded d-flex text-center align-items-center',
                    'spark-bg-secondary text-white' => Request::is('profile'),
                ])>
                    <i class="bi-person fs-1 pe-2"></i>
                    <span class="d-none d-lg-flex">Profile</span>
                </li>
            </a></a>



        </ul>
    </div>
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
