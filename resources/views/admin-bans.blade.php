@use('App\Models\Ban')

<x-app-layout>
    <x-slot:title>Bans - Admin Dashborad</x-slot>
    <x-admin-layout>

        <div class="row">
            <h2 class="col-12">
                Bans
            </h2>
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
                        @php
                            $bans = Ban::paginate(10);
                        @endphp
                        @foreach ($bans as $ban)
                            <tr>
                                <th scope="row">{{ $ban->id }}</th>
                                <td><a class="link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                                        href="/viewprofile/{{ $ban->user_id }}">{{ $ban->user->first_name . ' ' . $ban->user->second_name }}
                                    </a></td>
                                <td>{{ $ban->admin->first_name . ' ' . $ban->admin->second_name }}</td>
                                <td>{{ $ban->reason }}</td>
                                <td>{{ $ban->report_id }}</td>
                                <td>{{ $ban->active_from }}</td>
                                <td>{{ $ban->active_to ?? 'Permanent' }}</td>
                                <td>
                                    <form action="{{ route('ban.revoke') }}" method="POST">
                                        @csrf
                                        <input hidden type="text" name="id" value="{{ $ban->id }}">
                                        <button class="btn btn-primary">Unban</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $bans->links() }}

            </div>
        </div>

    </x-admin-layout>
</x-app-layout>
