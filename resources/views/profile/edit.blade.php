<x-app-layout>  
  
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8  shadow p-2 mb-3 bg-white rounded d-flex justify-content-between">
            <div class="prof">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Profile
            </h2>
</div>
<div class="settings">
<div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" style="background:#de3163" type="button" data-bs-toggle="dropdown" aria-expanded="false">
  <i class="bi bi-gear"></i>
  </button>
  <ul class="dropdown-menu">
    <li><a href="/profile" class="dropdown-item">Edit Profile</a></li>
    <li><a href="/profile?section=section2" class="dropdown-item">Update Password</a></li>
    <li><a href="/profile?section=section3"class="dropdown-item">Delete Account</a></li>
  </ul>
</div>
</div>
                </div>

    <div class="py-12">
        <div  class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
           
        <!-- Edit Profile -->
        @if (!isset($_GET['section']))
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-m">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
            <!-- Update Password -->
            @elseif (isset($_GET['section']) && $_GET['section'] == "section2")
            <div  class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-m">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Account -->
            @elseif (isset($_GET['section']) && $_GET['section'] == "section3")
            <div i class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-m">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

            <!-- Photo Selection 
            need array of photos, then foreach photo display a wee div and then make
        -->



    @endif
        </div>
    </div>
</x-app-layout>
