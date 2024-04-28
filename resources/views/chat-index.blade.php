<x-app-layout>

    <x-slot:title>Chat</x-slot>

    <main class="container-fluid">
        <div class="row justify-content-center align-items-center">
            <?php
            // // need to update this so it also shows if I sent the only message
            // $statement = $pdo->prepare('SELECT DISTINCT users.username, users.id,  last_activity, (select count(*) from messages where sender_id = users.id and receiver_id = :me and opened = 0) AS unread_count FROM messages JOIN users ON users.id = messages.sender_id WHERE receiver_id = :me');
            ?>
            <div class="col-md-4 mb-4 pt-4">
                <h3 class="text-center mb-4">Your Sparks</h3>
                <x-chat-user-list></x-chat-user-list>
            </div>
            <div class="col-8 p-5 d-none text-center d-md-flex justify-content-center align-items-center flex-column">
                <i class="bi-chat-dots chat-icon colored-text"></i>
                <h1 class="colored-text">Welcome to Spark Chat, {{ Auth::user()->first_name }}!</h1>
                <p class="colored-text">Click on a name to get started.</p>
            </div>
        </div>
    </main>
</x-app-layout>

<style>
    .chat-icon {
        font-size: 4.5em;

    }

    .colored-text {
        color: var(--spk-color-primary-2);
    }
</style>
