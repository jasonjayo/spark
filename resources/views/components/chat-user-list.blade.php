@use('App\Models\Profile')
@use ('App\Models\Photo')

@php
    $currentChatUserId = request()->route('id');
@endphp

<ul class='list-group overflow-y-scroll gap-3'>
    @php
        $profiles = Profile::whereIn('user_id', Auth::user()->getMatches())->get();
    @endphp
    @foreach ($profiles as $profile)
        <?php
        $photoUrls = [];

        foreach (Photo::where('user_id', $profile->user_id)->get() as $photo) {
            array_push($photoUrls, $photo->photo_url);
        }

        if (Arr::get($photoUrls, 0) == null) {
            $coverPhoto = 'https://placehold.co/300x300?text=Photo';
        } else {
            $coverPhoto = asset('images/profilePhotos/' . $photoUrls[0]);
        }
        ?>
        <a class='text-secondary user-row d-flex align-items-center profile-section{{ $profile->user->id == $currentChatUserId ? " active" : "" }}' href='{{ route('chat.show', $profile->user->id) }}'>
            <div class="profile-container">
                <img class="profile-photo" src="{{ $coverPhoto }}">
                @if ($profile->isActive())
                    <span title="Active now" class="profile-active online-now rounded-circle"></span>
                @else
                    <span title="Offline" class="profile-active offline rounded-circle"></span>
                @endif
            </div>
            @php
                $latest_message = Auth::user()->getLatestMessageWith($profile->user->id);
                $unread_count = Auth::user()->getUnreadMessagesCountWith($profile->user->id);
            @endphp
            <div class="ms-3">
                <div class="username">{{ $profile->user->first_name }} </div>
                <div class="message-preview">
                    @if ($latest_message)
                        @if ($unread_count > 0)
                            <span class="badge rounded-pill badge-primary">{{ $unread_count }}</span>
                        @endif
                        <span class="latest-message">
                            @if ($latest_message->sender_id == Auth::user()->id)
                                You:
                            @endif
                            {{ $latest_message->content }}
                        </span>
                    @endif
                </div>
            </div>
        </a>
    @endforeach
</ul>

<style>
    .profile-section {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.08);
        margin-bottom: 5px;
        margin-top: 5px;
        padding: 15px;
        transition: all 0.3s ease;
    }

    .profile-section:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
    }

    .profile-container {
        position: relative;
    }

    .profile-photo {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        object-fit: cover;
    }
    
    .online-now {
        background-color: #4caf50;
    }

    .offline {
        background-color: #808080;
    }

    .username {
        font-weight: bold;
        font-size: 20px;
    }

    .message-preview {
        margin-top: 5px;
        font-size: 14px;
        color: #6c757d;
    }

    .badge {
        font-size: 12px;
        margin-right: 5px;
    }

    .badge-primary {
        background-color: #007bff;
    }

    .latest-message {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .active {
        background-color: #e2f3ff;
        border-color: #de3163;
    }
</style>