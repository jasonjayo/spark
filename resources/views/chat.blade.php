@use('App\Models\User')

<x-app-layout>
    <main class="container p-3">
        <div class="row ms-2 me-2 mb-2">
            <div class="col-2">
                Hello, {{ Auth::user()->first_name }}
            </div>
        </div>
        <div class="row">
            <div class="col-3"></div>
            <div class="col-9 text-center d-flex justify-content-center align-items-center">
                <?php
                // $statement = $pdo->prepare('SELECT last_activity, username FROM users WHERE id = :user_id');
                // $statement->execute(['user_id' => $_GET['entity']]);
                
                // $result = $statement->fetch(PDO::FETCH_ASSOC);
                // echo "<strong><a href='./profile.php?user=" . $_GET['entity'] . "'>" . htmlspecialchars($result['username']) . '</a></strong>';
                
                // $last_activity = new DateTime($result['last_activity']);
                
                // $five_mins = DateInterval::createFromDateString('1 min');
                
                // $now = new DateTime();
                
                // if ($last_activity > $now->sub($five_mins)) {
                //     echo "<div title='Active now' class='ms-3 online-now text-bg-success rounded-circle'></div>";
                // } else {
                //     echo "<div title='Offline' class='ms-3 offline text-bg-secondary rounded-circle'></div>";
                // }
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <?php
                // echo "<ul class='list-group'>";
                // // need to update this so it also shows if I sent the only message
                // $statement = $pdo->prepare('SELECT DISTINCT users.username, users.id,  last_activity, (select count(*) from messages where sender_id = users.id and receiver_id = :me and opened = 0) AS unread_count FROM messages JOIN users ON users.id = messages.sender_id WHERE receiver_id = :me');
                // $statement->execute(['me' => $_SESSION['user_id']]);
                
                // foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $user) {
                //     $last_activity = $user['last_activity'];
                //     echo "<a class='list-group-item list-group-item-action d-flex justify-content-between align-items-center' href='?entity=" . $user['id'] . "'>" . htmlspecialchars($user['username']) . "<span class='badge bg-primary rounded-pill'>" . $user['unread_count'] . '</span>' . '</a>';
                // }
                
                // echo '</ul>';
                ?>
                <ul class='list-group'>
                    @foreach (User::all() as $user)
                        <a
                            class='list-group-item list-group-item-action d-flex justify-content-between align-items-center'>
                            {{ $user->first_name }}
                            @if ($user->profile->isActive())
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
                    <li class="m-1 p-2 d-inline-block rounded-3 bg-secondary text-light align-self-start ">hello</li>
                    <li class="m-1 p-2 d-inline-block rounded-3 bg-primary text-light align-self-end">again</li>
                    <li class="m-1 p-2 d-inline-block rounded-3 bg-secondary text-light align-self-start ">hello</li>
                    <li class="m-1 p-2 d-inline-block rounded-3 bg-primary text-light align-self-end">test</li>
                    <li class="m-1 p-2 d-inline-block rounded-3 bg-secondary text-light align-self-start ">asdadasd</li>
                    <li class="m-1 p-2 d-inline-block rounded-3 bg-primary text-light align-self-end">hey!</li>
                </ul>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-3"></div>
            <form class="col-9 m-auto d-flex pt-2" id="send-msg-form">
                <label class="visually-hidden" for="message">Message</label>
                <input type="text" class="form-control me-2" id="message" placeholder="Message">
                <button type="submit" class="btn btn-primary">Send</button>
            </form>
        </div>
    </main>
</x-app-layout>
