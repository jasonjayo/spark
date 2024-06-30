@use('App\Models\User')
@use('App\Models\Profile')
@use ('App\Models\Photo')


@pushOnce('scripts')
    @vite(['resources/js/chat.js', 'resources/css/viewprofile.css'])
@endPushOnce

<x-app-layout>
    <script>
        const other_user = {
            id: {{ request()->id }},
            first_name: "{{ $other_user->first_name }}"
        }
    </script>

    <x-slot:title>Chat</x-slot>

    <main class="container-fluid chat-page">
        <div class="row">
            <div class="col-4 col-md-4 d-none mb-4 d-md-block pt-4">
                <h3 class="text-center mb-4">Your Sparks</h3>
                <x-chat-user-list></x-chat-user-list>
            </div>
            <div id="inner" class="col-12 col-md-8">
                <!-- View Profile button with profile picture -->
                <div class="d-flex justify-content-between align-items-center border-bottom px-3 py-2">
                    <div class="d-flex align-items-center">
                        <a class="text-decoration-none text-black" href="{{ url('/viewprofile/' . $other_user->id) }}"
                            style="color: #de3163;">
                            <h4 class="fw-b">{{ $other_user->first_name }}</h4>
                        </a>
                    </div>
                    <div>
                        <button type="button" class="btn btn-lg btn-primary bg-transparent" data-bs-toggle="modal"
                            data-bs-target="#reportModal">
                            <span class="material-symbols-outlined text-danger" style="font-size: 40px;">flag</span>
                        </button>
                    </div>
                </div>
                <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="ban-modal-header modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                                <div class="ban-modal-title-container modal-title-container">
                                    <h5 class="modal-title" id="reportModalLabel">Report</h5>
                                    <p class="ban-modal-subtitle modal-subtitle">Don't worry,
                                        {{ $other_user->first_name }} won't find out.</p>
                                </div>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('report.create') }}" method="POST" id="reportForm">
                                    @csrf
                                    <input type="hidden" name="reported_id" value="{{ $other_user->id }}">
                                    <div class="mb-3">
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-report" name="reason"
                                                value="Inappropriate Messages">Inappropriate Messages</button>
                                            <button type="submit" class="btn btn-report" name="reason"
                                                value="Inappropriate Photos">Inappropriate Photos</button>
                                            <button type="submit" class="btn btn-report" name="reason"
                                                value="Spam">Feels like Spam</button>
                                            <button type="button" class="btn btn-report" data-bs-toggle="collapse"
                                                data-bs-target="#otherReasonField">Other</button>
                                        </div>
                                    </div>
                                </form>
                                <div class="collapse" id="otherReasonField">
                                    <form action="{{ route('report.create') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="reported_id" value="{{ $other_user->id }}">
                                        <div class="mb-3">
                                            <textarea class="form-control" id="otherReason" name="reason" rows="3" placeholder="Enter reason"></textarea>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Submit Report</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <ul id="messages" class="d-flex flex-column p-3 m-auto">
                    @foreach ($messages as $message)
                        @php
                            $isOwnMsg = $message->sender_id != Auth::user()->id;
                        @endphp
                        <li @class([
                            'm-1 p-2 d-inline-block rounded-3 chat-message',
                            'bg-primary text-light align-self-end' => !$isOwnMsg,
                            'bg-secondary text-light align-self-start' => $isOwnMsg,
                        ]) title="{{ $message->created }}">{{ $message->content }}</li>
                    @endforeach
                </ul>
                <div class="row">
                    <div class="col-md-9 col-12" id="typing-alert" x-data>
                        <span class="text-secondary"><span x-text="other_user.first_name"></span> is typing</span>
                        <span class="typing-dot text-secondary rounded"></span>
                        <span class="typing-dot text-secondary rounded"></span>
                        <span class="typing-dot text-secondary rounded"></span>
                    </div>
                </div>
                <div class="row">
                    <form class="col-12 m-auto d-flex pt-2" id="send-msg-form" x-data="">
                        @csrf
                        <label class="visually-hidden" for="message">Message</label>
                        <input autocomplete="off" type="text" class="form-control me-2" id="message"
                            placeholder="Message" name="content" @keydown.throttle.3000ms="whisperTyping">
                        <input hidden name="recipient_id" value="{{ request()->id }}">
                        <button type="submit" class="btn btn-primary">Send</button>
                    </form>
                </div>
                <div class="row">
                    <div class="col-12 pt-1 text-secondary" id="chat-connection-status">
                        Connecting to chat...
                    </div>
                </div>
            </div>
        </div>

        <div id="toasts"></div>
    </main>
</x-app-layout>
