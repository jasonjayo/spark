<x-app-layout>

    <x-slot:title>Chat</x-slot>

    <main class="container p-3">
        <div class="row ms-2 me-2 mb-2">
            <div class="col-12 col-md-3">
                Hello, {{ Auth::user()->first_name }}
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-3">
                <?php
                // // need to update this so it also shows if I sent the only message
                // $statement = $pdo->prepare('SELECT DISTINCT users.username, users.id,  last_activity, (select count(*) from messages where sender_id = users.id and receiver_id = :me and opened = 0) AS unread_count FROM messages JOIN users ON users.id = messages.sender_id WHERE receiver_id = :me');
                ?>
                <x-chat-user-list></x-chat-user-list>
            </div>
            <div class="col-9 d-none d-md-block text-center d-flex justify-content-center flex-column">
                <i class="bi-chat-dots"></i>
                <h1>Welcome to Spark Chat!</h1>
                <p>Click on a name to get started.</p>
            </div>
        </div>
    </main>
</x-app-layout>

<style>
    .bi-chat-dots {
        font-size: 4.5em;
    }
</style>
