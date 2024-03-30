@props(['profile'])
@use('PhpGeoMath\Model\Polar3dPoint')

@pushOnce('styles')
    <style>
        /* can be removed if this remains empty */
    </style>
@endPushOnce

<div class="card h-100 profile-card">
    <img src="https://placehold.co/300x300?text=Photo" class="card-img-top"
        alt="Photo of {{ $profile->user->first_name }}">
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
        <a href="{{ route('viewprofile', ['id' => $profile->user->id]) }}" class="btn btn-primary">View Profile</a>
    </div>
</div>
