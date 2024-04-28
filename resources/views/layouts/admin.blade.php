@use('App\Models\Report')
@use('App\Models\Ban')




<div class="container mt-4">

    @if (session('report_closed'))
        <div class="row">
            <div class="col-12">
                <div class="alert alert-success" role="alert">
                    Report successfully closed
                </div>
            </div>
        </div>
    @endif

    @if (session('ban_id'))
        <div class="row">
            <div class="col-12">
                <div class="alert alert-success" role="alert">
                    Ban created successfully (Ban ID: {{ session('ban_id') }})
                </div>
            </div>
        </div>
    @endif

    @if (session('ban_revoked'))
        <div class="row">
            <div class="col-12">
                <div class="alert alert-success" role="alert">
                    Ban successfully revoked
                </div>
            </div>
        </div>
    @endif

    @if (session('account_deleted'))
        <div class="row">
            <div class="col-12">
                <div class="alert alert-success" role="alert">
                    Account successfully deleted
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-9 mb-3">
            <h1>Admin Dashboard</h1>
        </div>
        <div class="col-3 d-flex justify-content-end align-items-center">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-primary">Logout</button>
            </form>
        </div>
    </div>

    {{ $slot }}

</div>

<script>
    function prepBanModal(e) {
        document.querySelector("#ban_user_id").value = e.target.getAttribute("data-reported-id");
        document.querySelector("#ban_report_id").value = e.target.getAttribute("data-report-id");
    }
</script>
