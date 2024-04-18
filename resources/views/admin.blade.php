@use('App\Models\Report')
@use('App\Models\Ban')

<x-app-layout>
    <x-slot:title>Admin Dashborad</x-slot>

    <div class="modal fade" id="banModal" tabindex="-1" aria-labelledby="banModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="banModalLabel">Ban User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="ban-form" action="{{ route('ban.create') }}" method="POST" x-data="{ permBan: false }">
                        @csrf
                        <div class="mb-3">
                            <label for="ban_user_id" class="form-label">User ID</label>
                            <input required type="number" class="form-control" id="ban_user_id" name="user_id">
                        </div>
                        <div class="mb-3">
                            <label for="ban_reason" class="form-label">Reason</label>
                            <input required type="text" class="form-control" autocomplete="off" id="ban_reason"
                                name="reason">
                        </div>
                        <div class="mb-3">
                            <label for="ban_report_id" class="form-label">Linked report (optional)</label>
                            <input required type="text" class="form-control" id="ban_report_id" name="report_id">
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" value="" x-model="permBan"
                                id="ban_perm">
                            <label class="form-check-label" for="ban_perm">
                                Permanent ban
                            </label>
                        </div>
                        <div class="mb-3" x-show="!permBan">
                            <label for="ban_expiry" class="form-label">Expiry</label>
                            <input type="date" class="form-control" id="ban_expiry" name="expiry">
                        </div>
                        <button type="submit" class="btn btn-primary">Ban</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

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

        <div class="row">
            <h1 class="col-12">
                Reports
            </h1>
        </div>

        <div class="row">
            <div class="col">
                <table class="table table-striped" x-data="">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Reporter</th>
                            <th scope="col">Reported</th>
                            <th scope="col">Reason</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        @foreach (Report::all() as $report)
                            <tr>
                                <th scope="row">{{ $report->id }}</th>
                                <td><a class="link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                                        href="viewprofile/{{ $report->reporter_id }}">{{ $report->reporter->first_name . ' ' . $report->reporter->second_name }}
                                    </a>
                                </td>
                                <td><a class="link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                                        href="viewprofile/{{ $report->reported_id }}">{{ $report->reported->first_name . ' ' . $report->reported->second_name }}</a>
                                </td>
                                <td>{{ $report->reason }}</td>
                                <td>{{ $report->status }}</td>
                                <td>
                                    @if ($report->status != 'CLOSED')
                                        <button class="btn btn-primary me-1" data-bs-toggle="modal"
                                            data-bs-target="#banModal" data-reported-id="{{ $report->reported_id }}"
                                            data-report-id="{{ $report->id }}" x-on:click="prepBanModal">Ban</button>
                                        <form action="{{ route('report.close') }}" method="POST"
                                            class="d-inline-block">
                                            @csrf
                                            <input type="text" hidden name="id" value="{{ $report->id }}">
                                            <button class="btn btn-primary">Close</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <h1 class="col-12">
                Bans
            </h1>
        </div>

        <div class="row">
            <div class="col">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">User</th>
                            <th scope="col">Admin</th>
                            <th scope="col">Reason</th>
                            <th scope="col">Report ID</th>
                            <th scope="col">Active From</th>
                            <th scope="col">Active To</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        @foreach (Ban::all() as $ban)
                            <tr>
                                <th scope="row">{{ $ban->id }}</th>
                                <td><a class="link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                                        href="viewprofile/{{ $ban->user_id }}">{{ $ban->user->first_name . ' ' . $ban->user->second_name }}
                                    </a></td>
                                <td>{{ $ban->admin->first_name }}</td>
                                <td>{{ $ban->reason }}</td>
                                <td>{{ $ban->report_id }}</td>
                                <td>{{ $ban->active_from }}</td>
                                <td>{{ $ban->active_to ?? 'Permanent' }}</td>
                                <td>
                                    <form action="{{ route('ban.revoke') }}" method="POST">
                                        @csrf
                                        <input hidden type="text" name="id" value="{{ $ban->id }}">
                                        <button class="btn btn-primary">Revoke</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


    </div>

    <script>
        function prepBanModal(e) {
            document.querySelector("#ban_user_id").value = e.target.getAttribute("data-reported-id");
            document.querySelector("#ban_report_id").value = e.target.getAttribute("data-report-id");

        }
    </script>

</x-app-layout>
