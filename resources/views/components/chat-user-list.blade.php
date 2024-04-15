@use('App\Models\Profile')
@use ('App\Models\Photo')
<ul class='list-group overflow-scroll gap-1'>
    @foreach (Profile::all()->except(Auth::user()->id) as $profile)
        <?php
        $photoUrls = [];
        ?>

        @foreach (Photo::where('user_id', $profile->user_id)->get() as $photo)
            <?php array_push($photoUrls, $photo->photo_url); ?>
        @endforeach

        <?php
        if (Arr::get($photoUrls, 0) == null) {
            $coverPhoto = 'https://placehold.co/300x300?text=Photo';
        } else {
            $coverPhoto = asset('images/profilePhotos/' . $photoUrls[0]);
        }
        ?>
        <a class=' bg-white user-row d-flex justify-content-between align-items-center'
            href='{{ route('chat.show', $profile->user->id) }}'>
            <div class="profile-container">
            <img class="profile-photo" src="{{$coverPhoto}}">
                @if ($profile->isActive())
                <span title="Active now" class=" profile-active online-now text-bg-success rounded-circle"></span>
                @else
                    <span title="Offline" class="profile-active offline text-bg-secondary rounded-circle"></span>
                @endif
            </div>
            
           
            </img>
            <div class="username">{{ $profile->user->first_name }} </div>
        </a>
    @endforeach
</ul>
