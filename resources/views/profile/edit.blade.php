<x-app-layout>  
    <x-slot name="header" class="d-flex">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
        <h3>Bruh</h3>
        </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-m">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Should these be their own pages??  Update Password -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-m">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

             <!-- Should these be their own pages?? Delete Account -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-m">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
