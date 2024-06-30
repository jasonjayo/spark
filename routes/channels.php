<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// used for notifications
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// used for realtime chat
Broadcast::channel('chat.{user_1}.{user_2}', function ($user, $user_1_id, $user_2_id) {
    return ((int) $user->id === (int) $user_1_id) || ((int) $user->id === (int) $user_2_id);
});
