@use('App\Models\Photo')

<section>
    <style>
        .imgContainer {
            position: relative;
        }

        .img {
            opacity: 1;
            display: block;
            width: 100%;
            transition: .5s ease;
            backface-visibility: hidden;
            object-fit: cover;
            width: 230px;
            height: 200px;
            border-radius: 10%;
            border: 3px solid #b61a47;
            overflow: auto;

        }

        .buttonContainer {
            transition: .5s ease;
            opacity: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            text-align: center;
        }

        .imgContainer:hover .img {
            opacity: 0.3;
        }

        .imgContainer:hover .buttonContainer {
            opacity: 1;
        }
    </style>
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
    @elseif (session('status') === 'photo-deleted')
        <div class="alert alert-success" role="alert">
            Photo deleted!
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

    <form method="post" action="{{ route('photo.store') }}" enctype="multipart/form-data">
        @csrf

        <input type="text" name="id" value="{{ $user->id }}" hidden>

        <div class="mb-3">
            <label for="image" class="form-label">
                <h4>Add Photo</h4>
            </label>
            <input class="form-control" type="file" name="image" id="image">
        </div>

        <div class="form-floating mb-3">
            <input class="form-control mb-3" type="text" name="photoName" id="photoName"
                placeholder="Selfie with my Dog">
            <label for="photoName">Photo Name </label>
        </div>

        <!-- <input class="form-control mb-3" type="text" name="photoName"> -->
        <button type="submit" name="photo" class="btn btn-primary">Upload Photo</button>
    </form>


    <br>

    <div class="mb-3 mt-4">
        <h4>Current Photo Selection</h4>
    </div>
    <div class="container">
        <div class="row ">

            <form method="post" action="{{ route('photo.destroy') }}">
                @csrf
                @method('delete')

                @foreach (Photo::where('user_id', $user->id)->get() as $photo)
                    <div class="imgContainer d-flex justify-content-center col-3 my-1">
                        <img src="{{ asset('images/profilePhotos/' . $photo->photo_url) }}" class="img" />
                        <div class="buttonContainer">
                            <input type="hidden" id="photoId" name="photoId" value= "{{ $photo->id }}" />
                            <input type="hidden" id="photoUrl" name="photoUrl" value= "{{ $photo->photo_url }}" />
                            <button type="submit" name="photoDelete" class="delBtn btn btn-primary">Delete
                                Photo</button>
                        </div>

                    </div>
                @endforeach
            </form>
        </div>
    </div>

</section>
