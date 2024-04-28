@props(['profile'])
@use ('App\Models\Photo')
@use ('App\Models\Profile')

@pushOnce('styles')
    <style>
        .card:hover {
            border-color: var(--spk-color-primary-1);
            transition: 0.1s linear;
        }

        .card {
            text-decoration: none;
            border-width: 2px;
            border-radius: 3px;
            border-color: transparent;
        }
    </style>
@endPushOnce
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





<a href="{{ route('viewprofile', ['id' => $profile->user->id]) }}" class="card h-100 profile-card">
    <img src="{{ $coverPhoto }}" class="card-img-top" alt="Photo of {{ $profile->user->first_name }}" height="247.3px"
        width="247.3px" style="object-fit: cover">
    <div class="card-body">
        <h4 class="card-title d-flex justify-content-between">
            <div class="d-flex align-items-center">{{ $profile->user->first_name }}
                @if ($profile->isActive())
                    <span title="Active now" class="online-now ms-3 text-bg-success rounded-circle"></span>
                @else
                    <span title="Offline" class="offline ms-3 text-bg-secondary rounded-circle"></span>
                @endif
            </div>
            <div>{{ $profile->getAge() }}</div>
        </h4>
        @if (!$profile->isActive())
            Last seen {{ $profile->getLastActive() }}
        @endif
        <p class="card-text">
            {{ $profile->tagline }}
        <ul>
            <li>{{ $profile->gender->getLabel() }}</li>
            <li>Interested in: {{ $profile->interested_in->getLabel() }}</li>
            <li>Looking for: {{ $profile->seeking->getLabel() }}</li>
            @isset($profile->university)
                <li>{{ $profile->university }}</li>
            @endisset
            @if ($profile->getDistance() != null)
                <li>{{ $profile->getDistance() }}</li>
            @endif
        </ul>
        </p>
    </div>
</a>
