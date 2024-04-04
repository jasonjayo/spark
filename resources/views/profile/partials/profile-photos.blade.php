@use('App\Models\Photo')

<section>
<header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Update Photos') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Update your profile photos here.') }}
        </p>
    </header>
    @if (session('status') === 'photo-saved')
        <div class="alert alert-success" role="alert">
            Photo saved!
        </div>
    @endif
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="post" action="{{ route('profile.store') }}" enctype="multipart/form-data">
@csrf
    <div class="mb-3">
  <label for="image" class="form-label">
    <h4>Add Photo</h4>
  </label>
  <input class="form-control" type="file" name="image" id="image">
</div>

<div class="form-floating mb-3"> 
<input class="form-control mb-3" type="text" name="photoName" id="photoName" placeholder="Selfie with my Dog">
<label for="photoName">Photo Name </label>
</div>

<!-- <input class="form-control mb-3" type="text" name="photoName"> -->
<button type="submit" name="photo" class="btn btn-primary">Upload Photo</button>

</form>

<br>
    <div class="container-fluid">
    <div class="row">


    @foreach (Photo::where('user_id', auth()->id())->get() as $photo)
    <div class="col my-1 mx-1">
    <img 
    src="{{ asset('images/profilePhotos/' . $photo->photo_url) }}" 
    width="150" height="150" alt="pic">
    </div>
    @endforeach

</div>
</div>

</section>