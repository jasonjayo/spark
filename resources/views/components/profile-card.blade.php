@props(['profile'])

<style>
    .online-now,
    .offline {
        width: 10px;
        height: 10px;
        display: inline-block;
        position: relative;
    }

    .online-now::before {
        width: 13px;
        height: 13px;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translateX(-50%) translateY(-50%);
        content: "";
        display: block;
        animation: online-pulse 2s infinite;
        background: var(--bs-success);
        border-radius: 50%;
        z-index: 1;
    }

    @keyframes online-pulse {
        0% {
            opacity: 0.8;
            transform: translateX(-50%) translateY(-50%) scale(0.8);
        }

        100% {
            opacity: 0;
            transform: translateX(-50%) translateY(-50%) scale(1.5);
        }
    }
</style>

<div class="card h-100 profile-card" style="width: 18rem;">
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
            <li>Interested in: {{ $profile->interested_in->getLabel() }}</li>
            <li>Looking for: {{ $profile->seeking->getLabel() }}</li>
            @isset($profile->university)
                <li>{{ $profile->university }}</li>
            @endisset
        </ul>
        </p>
        <a href="#" class="btn btn-primary">View Profile</a>
    </div>
</div>
