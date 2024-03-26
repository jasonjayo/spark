<style>
    .nav-logo {
        height: 80px;
    }

    .spark-bg-primary {
        background: #DE3163
    }

    .spark-bg-secondary {
        background: #B61A47;
    }

    #links {
        min-height: 70vh;
    }
</style>
<nav class="d-flex justify-content-between p-4 border-bottom border-2 position-relative z-1 bg-white">
    <img class="nav-logo" src="{{ asset('./images/logos/spark_cerise.png') }}" alt="">

    <div class="d-flex">
        <ul class="nav-links list-group d-flex flex-row justify-content-center fs-5">
            <a href="./dashboard" class="text-decoration-none text-black">
                <li
                    class="p-3 m-3 rounded  d-flex text-center align-items-center {{ Request::is('dashboard') ? 'spark-bg-secondary' : '' }}">
                    <span class="material-symbols-outlined fs-1 pe-2">
                        star
                    </span>Discover
                </li>
            </a>
            <li class="p-3 m-3 d-flex text-center align-items-center">
                <span class="material-symbols-outlined fs-1 pe-2">
                    search
                </span>Search
            </li>
            <li class="p-3 m-3 d-flex text-center align-items-center">
                <span class="material-symbols-outlined fs-1 pe-2">
                    chat
                </span>Chat
            </li>
            <a href="./profile" class="text-decoration-none text-black">
            <li class="p-3 m-3 rounded d-flex text-center align-items-center {{ Request::is('dashboard') ? 'spark-bg-secondary' : '' }}">
                <span class="material-symbols-outlined fs-1 pe-2">
                    person
                </span>Profile
            </li>
</a>



        </ul>
    </div>
</nav>

<div class="container-fluid">
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
</div>
