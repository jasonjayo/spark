@use('App\Models\User')
@use('App\Models\Profile')

@pushOnce('scripts')
    @vite(['resources/js/chat.js'])
@endPushOnce

<x-app-layout>
    <script>
        const user_id = {{ auth()->user()->id }};
        const other_user = {
            id: {{ request()->id }},
            first_name: "{{ User::find(request()->id)->first_name }}"
        }
    </script>

    <x-slot:title>Chat</x-slot>

    <main class="container p-3">
        <div class="row ms-2 me-2 mb-2">
            <div class="col-2">
                Hello, {{ Auth::user()->first_name }}
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <?php
                // // need to update this so it also shows if I sent the only message
                // $statement = $pdo->prepare('SELECT DISTINCT users.username, users.id,  last_activity, (select count(*) from messages where sender_id = users.id and receiver_id = :me and opened = 0) AS unread_count FROM messages JOIN users ON users.id = messages.sender_id WHERE receiver_id = :me');
                ?>
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
            </div>
            <div id="inner" class="col-9">
                <ul id="messages" class="d-flex flex-column p-3 m-auto">
                    @foreach ($messages as $message)
                        @php
                            $isOwnMsg = $message->sender_id != Auth::user()->id;
                        @endphp
                        <li @class([
                            'm-1 p-2 d-inline-block rounded-3 chat-message',
                            'bg-primary text-light align-self-end' => !$isOwnMsg,
                            'bg-secondary text-light align-self-start' => $isOwnMsg,
                        ])>{{ $message->content }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-3"></div>
            <div class="col-9" id="typing-alert" x-data>
                <span class="text-secondary"><span x-text="other_user.first_name"></span> is typing</span>
                <span class="typing-dot text-secondary rounded"></span>
                <span class="typing-dot text-secondary rounded"></span>
                <span class="typing-dot text-secondary rounded"></span>
            </div>
        </div>
        <div class="row">
            <div class="col-3"></div>
            <form class="col-9 m-auto d-flex pt-2" id="send-msg-form" x-data="">
                @csrf
                <label class="visually-hidden" for="message">Message</label>
                <input autocomplete="off" type="text" class="form-control me-2" id="message" placeholder="Message"
                    name="content" @keydown.throttle.3000ms="whisperTyping">
                <input hidden name="recipient_id" value="{{ request()->id }}">
                <button type="submit" class="btn btn-primary">Send</button>
            </form>
        </div>
        <div class="row">
            <div class="col-3"></div>
            <div class="col-9 pt-1 text-secondary" id="chat-connection-status">
                Connecting to chat...
            </div>
        </div>
        <div id="toasts"></div>
    </main>
</x-app-layout>
