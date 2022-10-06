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

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


Broadcast::channel('postCreate23', function ($post) {

    info("Load from chanell");
     return true;
  // return (int) auth()->user()->id != (int) $post->user_id;

});
Broadcast::channel('chat23', function ($post) {
    info("Load from chanell");
    return true;
    // return (int) auth()->user()->id != (int) $post->user_id;

});
Broadcast::channel('chatAdmin', function ($post) {
    info("Load from chanell");
    return true;
    // return (int) auth()->user()->id != (int) $post->user_id;

});
