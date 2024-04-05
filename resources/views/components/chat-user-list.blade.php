@use('App\Models\Profile')

<ul class='list-group'>
    @foreach (Profile::all() as $profile)
        <a class='list-group-item list-group-item-action d-flex justify-content-between align-items-center'
            href='{{ route('chat.show', $profile->user->id) }}'>
            {{ $profile->user->first_name }}
            @if ($profile->isActive())
                <span title="Active now" class="online-now ms-3 text-bg-success rounded-circle"></span>
            @else
                <span title="Offline" class="offline ms-3 text-bg-secondary rounded-circle"></span>
            @endif
        </a>
    @endforeach
</ul>
