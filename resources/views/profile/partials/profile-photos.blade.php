<section>
<header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Update Photos') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Update your profile photos here.') }}
        </p>
    </header>

    <div class="container-fluid">
    <div class="row">

    @foreach (DB::table('photos')->get() as $photo)
    <div class="col my-1 mx-1">
    <img src="{{$photo->photo_url }}" width="150" height="150" alt="meant to be cool pic">
    </div>
    @endforeach

</div>
</div>
</section>