@use('App\Models\Report')

<x-app-layout>
    <x-slot:title>Bans - Admin Dashborad</x-slot>

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

    <x-admin-layout>

        <div class="row">
            <h2 class="col-12">
                Reports
            </h2>
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
                        @php
                            $reports = Report::orderBy('id', 'desc')->paginate(10);
                        @endphp
                        @foreach ($reports as $report)
                            <tr>
                                <th scope="row">{{ $report->id }}</th>

                                <td>
                                    @if ($report->reporter)
                                        <a class="link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                                            href="/viewprofile/{{ $report->reporter_id }}">
                                    @endif
                                    {{ $report->getReporterName() }}
                                    @if ($report->reporter)
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <a class="link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                                        href="/viewprofile/{{ $report->reported_id }}">
                                        {{ $report->getReportedName() }}
                                    </a>
                                </td>
                                <td>{{ $report->reason }}</td>
                                <td>{{ $report->status }}</td>
                                <td>
                                    @if ($report->status != 'CLOSED')
                                        <button class="btn btn-primary me-1" data-bs-toggle="modal"
                                            data-bs-target="#banModal" data-reported-id="{{ $report->reported_id }}"
                                            data-report-id="{{ $report->id }}"
                                            x-on:click="prepBanModal">Ban</button>
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
                {{ $reports->links() }}
            </div>
        </div>
    </x-admin-layout>

</x-app-layout>
