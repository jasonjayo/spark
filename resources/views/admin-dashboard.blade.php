<x-app-layout>
    <x-slot:title>Admin Dashborad</x-slot>
    <x-admin-layout>
        <div class="row g-4">
            <div class="col-md-6">
                <div>
                    <a class="text-decoration-none fw-bold justify-content-center text-uppercase d-flex fs-3 p-4 bg-body rounded-4"
                        href="{{ route('admin.reports') }}">
                        <span class="material-symbols-outlined me-2" style="font-size: 40px;">flag</span>Reports
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                <div>
                    <a class="text-decoration-none fw-bold justify-content-center text-uppercase d-flex fs-3 p-4 bg-body rounded-4"
                        href="{{ route('admin.bans') }}">
                        <span class="material-symbols-outlined me-2" style="font-size: 40px;">dangerous</span>Bans
                    </a>
                </div>
            </div>
    </x-admin-layout>
</x-app-layout>
